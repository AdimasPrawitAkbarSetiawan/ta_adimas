@extends('admin.layout.app')

@section('title', 'Edit User')
@section('page-title', 'Edit User')

@section('content')

<div class="bg-white rounded-2xl shadow-sm p-6">
    <h2 class="text-xl font-bold text-gray-800 mb-6">EDIT USER</h2>

    <form method="POST" action="{{ route('admin.user.update', $user->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="flex gap-6">

            {{-- Foto --}}
            <div class="flex flex-col items-center gap-2 w-40 flex-shrink-0">
                <div class="w-24 h-24 rounded-xl bg-blue-100 flex items-center justify-center overflow-hidden" id="preview-wrap">
                    @if($user->avatar)
                        <img src="{{ Storage::url($user->avatar) }}" class="w-24 h-24 rounded-xl object-cover"
                             onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=3b5bdb&color=fff&size=96'">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=3b5bdb&color=fff&size=96"
                             class="w-24 h-24 rounded-xl object-cover">
                    @endif
                </div>
                <label for="foto" class="cursor-pointer text-xs text-gray-500 border border-gray-300 rounded-lg px-3 py-1 hover:bg-gray-50">
                    Ganti Foto
                </label>
                <input type="file" id="foto" name="foto" accept="image/*" class="hidden" onchange="previewPhoto(event)">
            </div>

            {{-- Form Fields --}}
            <div class="flex-1 grid grid-cols-2 gap-4">

                <div>
                    <label class="text-xs text-gray-500 mb-1 block">Nama Lengkap</label>
                    <input type="text" name="name" placeholder="Masukkan Nama Lengkap"
                           value="{{ old('name', $user->name) }}"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 @error('name') border-red-400 @enderror">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="text-xs text-gray-500 mb-1 block">Role</label>
                    <select name="role"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                        @foreach(['marketing','operasional','owner','klien'] as $role)
                            <option value="{{ $role }}" {{ old('role', $user->role) == $role ? 'selected' : '' }}>
                                {{ ucfirst($role) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="text-xs text-gray-500 mb-1 block">Email</label>
                    <input type="email" name="email" placeholder="Masukkan Email"
                           value="{{ old('email', $user->email) }}"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 @error('email') border-red-400 @enderror">
                    @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="text-xs text-gray-500 mb-1 block">Password <span class="text-gray-400">(kosongkan jika tidak diubah)</span></label>
                    <input type="password" name="password" placeholder="Masukkan Password Baru"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 @error('password') border-red-400 @enderror">
                    @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="text-xs text-gray-500 mb-1 block">No Telepon</label>
                    <input type="text" name="phone" placeholder="Masukkan No Telepon"
                           value="{{ old('phone', $user->klien->phone ?? '') }}"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                </div>

                <div>
                    <label class="text-xs text-gray-500 mb-1 block">Status</label>
                    <select name="is_active"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                        <option value="1" {{ old('is_active', $user->is_active) == 1 ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ old('is_active', $user->is_active) == 0 ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>

            </div>
        </div>

        {{-- Alamat --}}
        <div class="mt-4">
            <label class="text-xs text-gray-500 mb-1 block">Alamat</label>
            <input type="text" name="address" placeholder="Masukkan Alamat Lengkap"
                   value="{{ old('address', $user->klien->address ?? '') }}"
                   class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
        </div>

        {{-- Tombol --}}
        <div class="flex justify-end gap-3 mt-8">
            <a href="{{ route('admin.user.index') }}"
               class="px-6 py-2 bg-red-500 text-white rounded-lg text-sm font-semibold hover:bg-red-600">
                BATAL
            </a>
            <button type="submit"
                    class="px-6 py-2 bg-green-500 text-white rounded-lg text-sm font-semibold hover:bg-green-600">
                SIMPAN
            </button>
        </div>

    </form>
</div>

@endsection

@push('scripts')
<script>
function previewPhoto(event) {
    const file = event.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('preview-wrap').innerHTML =
            `<img src="${e.target.result}" class="w-24 h-24 rounded-xl object-cover">`;
    };
    reader.readAsDataURL(file);
}
</script>
@endpush