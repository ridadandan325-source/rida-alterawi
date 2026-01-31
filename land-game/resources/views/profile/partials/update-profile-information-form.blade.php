<section>
    <header class="mb-4">
        <h2 class="h5 fw-bold mb-2">معلومات الملف الشخصي</h2>
        <p class="text-muted small mb-0">قم بتحديث معلومات ملفك الشخصي وعنوان بريدك الإلكتروني.</p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <div class="mb-3">
            <x-input-label for="name" :value="__('الاسم')" />
            <x-text-input 
                id="name" 
                name="name" 
                type="text" 
                class="form-control" 
                :value="old('name', $user->name)" 
                required 
                autofocus 
                autocomplete="name" />
            <x-input-error class="mt-1" :messages="$errors->get('name')" />
        </div>

        <div class="mb-3">
            <x-input-label for="email" :value="__('البريد الإلكتروني')" />
            <x-text-input 
                id="email" 
                name="email" 
                type="email" 
                class="form-control" 
                :value="old('email', $user->email)" 
                required 
                autocomplete="username" />
            <x-input-error class="mt-1" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="alert alert-warning mt-3">
                    <p class="mb-2 small">
                        {{ __('لم يتم التحقق من بريدك الإلكتروني.') }}
                        <button form="send-verification" class="btn btn-link p-0 text-decoration-none">
                            {{ __('انقر هنا لإعادة إرسال رابط التحقق.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mb-0 small text-success">
                            {{ __('تم إرسال رابط تحقق جديد إلى بريدك الإلكتروني.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="d-flex align-items-center gap-3">
            <x-primary-button>
                {{ __('حفظ') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-success small mb-0"
                >{{ __('تم الحفظ.') }}</p>
            @endif
        </div>
    </form>
</section>
