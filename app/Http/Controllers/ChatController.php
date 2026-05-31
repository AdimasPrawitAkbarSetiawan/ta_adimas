<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ChatController extends Controller
{
    public function index()
    {
        $users = User::where('id', '!=', Auth::id())
            ->when(Auth::user()->role === 'klien', function ($q) {
                $q->whereNotIn('role', ['klien']);
            })
            ->get();
        $unreadCounts = Message::where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->selectRaw('sender_id, count(*) as count')
            ->groupBy('sender_id')
            ->pluck('count', 'sender_id');

        return view('chat.index', compact('users', 'unreadCounts'));
    }

    public function users()
    {
        $users = User::where('id', '!=', Auth::id())
            ->when(Auth::user()->role === 'klien', function ($q) {
                $q->whereNotIn('role', ['klien']);
            })
            ->get()
            ->map(function ($user) {
                $unread = Message::where('sender_id', $user->id)
                    ->where('receiver_id', Auth::id())
                    ->where('is_read', false)
                    ->count();
                return [
                    'id'         => $user->id,
                    'name'       => $user->name,
                    'role'       => $user->role,
                    'avatar_url' => $user->avatar ? Storage::url($user->avatar) : null,
                    'unread'     => $unread,
                ];
            });

        return response()->json($users);
    }

    public function getMessages($userId)
    {
        $messages = Message::where(function ($q) use ($userId) {
            $q->where('sender_id', Auth::id())->where('receiver_id', $userId);
        })->orWhere(function ($q) use ($userId) {
            $q->where('sender_id', $userId)->where('receiver_id', Auth::id());
        })
            ->with('sender')
            ->orderBy('created_at', 'asc')
            ->get();

        Message::where('sender_id', $userId)
            ->where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json($messages);
    }

    public function send(Request $request)
    {
        $request->validate(['receiver_id' => 'required|exists:users,id', 'message' => 'required|string']);

        $message = Message::create([
            'sender_id'   => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message'     => $request->message,
        ]);

        $message->load('sender');

        return response()->json($message);
    }

    public function unreadCount()
    {
        $count = Message::where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->count();

        return response()->json(['count' => $count]);
    }
}