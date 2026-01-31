<x-app-layout>
    <div class="position-relative overflow-hidden">
        {{-- Ambient Background Glows --}}
        <div class="position-absolute top-0 start-50 translate-middle-x pointer-events-none" style="z-index: 0;">
            <div class="bg-gradient-primary opacity-20 blur-3xl rounded-circle" style="width: 800px; height: 800px;"></div>
        </div>

        <div class="container py-5 position-relative" style="z-index: 1;">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    {{-- Header --}}
                    <div class="text-center mb-5">
                        <h2 class="display-5 fw-bold mb-2 text-gradient-primary font-serif tracking-tight">
                            Profile Settings
                        </h2>
                        <p class="text-muted font-sans">
                            Update your personal information and account preferences
                        </p>
                    </div>

                    <div class="card border-0 shadow-2xl bg-glass overflow-hidden mb-5" style="border-radius: 24px;">
                        <div class="card-header border-glass bg-transparent p-5 pb-0">
                            <div class="d-flex align-items-center gap-4">
                                <div class="bg-gradient-primary p-3 rounded-circle shadow-lg text-white">
                                    <i class="fas fa-user-circle fa-2x"></i>
                                </div>
                                <div>
                                    <h4 class="mb-1 fw-bold text-dark font-serif">Account Details</h4>
                                    <p class="text-muted small mb-0">Manage your identity and security</p>
                                </div>
                            </div>
                        </div>

                        <div class="card-body p-5">
                            <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
                                @csrf
                                @method('patch')

                                <div class="mb-4">
                                    <x-input-label for="name" :value="__('Display Name')" class="small fw-bold text-uppercase ls-1 text-muted mb-2" />
                                    <x-text-input id="name" name="name" type="text" 
                                        class="form-control form-control-lg bg-glass-lighter border-glass shadow-none fw-semibold" 
                                        :value="old('name', $user->name)" required autofocus autocomplete="name" />
                                    <x-input-error class="mt-2 text-danger small" :messages="$errors->get('name')" />
                                </div>

                                <div class="mb-5">
                                    <x-input-label for="email" :value="__('Email Address')" class="small fw-bold text-uppercase ls-1 text-muted mb-2" />
                                    <x-text-input id="email" name="email" type="email" 
                                        class="form-control form-control-lg bg-glass-lighter border-glass shadow-none fw-semibold" 
                                        :value="old('email', $user->email)" required autocomplete="username" />
                                    <x-input-error class="mt-2 text-danger small" :messages="$errors->get('email')" />

                                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                        <div class="mt-3 p-3 bg-warning bg-opacity-10 rounded-3 border border-warning border-opacity-20">
                                            <p class="text-warning small mb-2 fw-bold">
                                                {{ __('Your email address is unverified.') }}
                                            </p>

                                            <button form="send-verification" class="btn btn-sm btn-warning rounded-pill fw-bold shadow-sm">
                                                {{ __('Resend Verification Email') }}
                                            </button>

                                            @if (session('status') === 'verification-link-sent')
                                                <p class="mt-2 text-success small fw-bold">
                                                    {{ __('A new verification link has been sent to your email address.') }}
                                                </p>
                                            @endif
                                        </div>
                                    @endif
                                </div>

                                <div class="d-flex align-items-center justify-content-between pt-4 border-top border-glass">
                                    <a href="{{ route('dashboard') }}" class="btn btn-link text-muted text-decoration-none hover-scale ps-0">
                                        <i class="fas fa-arrow-left me-2"></i> Cancel
                                    </a>

                                    <div class="d-flex align-items-center gap-3">
                                        @if (session('status') === 'profile-updated')
                                            <p
                                                x-data="{ show: true }"
                                                x-show="show"
                                                x-transition
                                                x-init="setTimeout(() => show = false, 2000)"
                                                class="small text-success fw-bold mb-0"
                                            ><i class="fas fa-check-circle me-1"></i> {{ __('Saved successfully.') }}</p>
                                        @endif

                                        <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5 fw-bold shadow-lg hover-scale">
                                            {{ __('Save Changes') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Security Section --}}
                    <div class="card border-0 shadow-2xl bg-glass overflow-hidden mb-5" style="border-radius: 24px;">
                        <div class="card-header border-glass bg-transparent p-5 pb-0">
                            <div class="d-flex align-items-center gap-4">
                                <div class="bg-gradient-gold p-3 rounded-circle shadow-lg text-white">
                                    <i class="fas fa-lock fa-2x"></i>
                                </div>
                                <div>
                                    <h4 class="mb-1 fw-bold text-dark font-serif">Security Settings</h4>
                                    <p class="text-muted small mb-0">Update your password to stay secure</p>
                                </div>
                            </div>
                        </div>

                        <div class="card-body p-5">
                            <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
                                @csrf
                                @method('put')

                                <div class="mb-4">
                                    <label class="form-label small fw-bold text-uppercase ls-1 text-muted mb-2">Current Password</label>
                                    <input name="current_password" type="password" class="form-control form-control-lg bg-glass-lighter border-glass shadow-none fw-semibold" autocomplete="current-password">
                                    <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-danger small" />
                                </div>

                                <div class="mb-4">
                                    <label class="form-label small fw-bold text-uppercase ls-1 text-muted mb-2">New Password</label>
                                    <input name="password" type="password" class="form-control form-control-lg bg-glass-lighter border-glass shadow-none fw-semibold" autocomplete="new-password">
                                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-danger small" />
                                </div>

                                <div class="mb-5">
                                    <label class="form-label small fw-bold text-uppercase ls-1 text-muted mb-2">Confirm Password</label>
                                    <input name="password_confirmation" type="password" class="form-control form-control-lg bg-glass-lighter border-glass shadow-none fw-semibold" autocomplete="new-password">
                                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-danger small" />
                                </div>

                                <div class="d-flex align-items-center justify-content-end pt-4 border-top border-glass">
                                    @if (session('status') === 'password-updated')
                                        <p
                                            x-data="{ show: true }"
                                            x-show="show"
                                            x-transition
                                            x-init="setTimeout(() => show = false, 2000)"
                                            class="small text-success fw-bold mb-0 me-3"
                                        ><i class="fas fa-check-circle me-1"></i> {{ __('Password updated.') }}</p>
                                    @endif

                                    <button type="submit" class="btn btn-warning btn-lg rounded-pill px-5 fw-bold shadow-lg hover-scale text-white">
                                        {{ __('Update Password') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Delete Account Section --}}
                    <div class="card border-0 shadow-2xl bg-glass overflow-hidden" style="border-radius: 24px;">
                        <div class="card-header border-glass bg-transparent p-5 pb-0">
                            <div class="d-flex align-items-center gap-4">
                                <div class="bg-gradient-danger p-3 rounded-circle shadow-lg text-white">
                                    <i class="fas fa-exclamation-triangle fa-2x"></i>
                                </div>
                                <div>
                                    <h4 class="mb-1 fw-bold text-dark font-serif">Danger Zone</h4>
                                    <p class="text-muted small mb-0">Irreversible account actions</p>
                                </div>
                            </div>
                        </div>

                        <div class="card-body p-5">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h5 class="fw-bold text-dark">Delete Account</h5>
                                    <p class="text-muted small mb-0" style="max-width: 400px;">
                                        Once your account is deleted, all of its resources and data will be permanently deleted.
                                    </p>
                                </div>
                                
                                <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')" class="btn btn-outline-danger btn-lg rounded-pill px-5 fw-bold hover-scale border-glass">
                                    {{ __('Delete Account') }}
                                </button>
                            </div>

                            <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
                                <form method="post" action="{{ route('profile.destroy') }}" class="p-4 bg-white rounded-4">
                                    @csrf
                                    @method('delete')

                                    <div class="text-center mb-4">
                                        <div class="mb-3 text-danger display-4">
                                            <i class="fas fa-trash-alt"></i>
                                        </div>
                                        <h2 class="h4 fw-bold text-dark mb-2">
                                            {{ __('Are you sure you want to delete your account?') }}
                                        </h2>
                                        <p class="text-muted small mx-auto" style="max-width: 400px;">
                                            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                                        </p>
                                    </div>

                                    <div class="mb-4">
                                        <label for="password" class="form-label fw-bold small text-uppercase text-muted">{{ __('Password') }}</label>
                                        <input
                                            id="password"
                                            name="password"
                                            type="password"
                                            class="form-control form-control-lg bg-light border-0 shadow-inner"
                                            placeholder="{{ __('Enter your password') }}"
                                        />
                                        <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-danger small" />
                                    </div>

                                    <div class="d-flex justify-content-end gap-2">
                                        <button type="button" class="btn btn-light rounded-pill px-4 fw-bold" x-on:click="$dispatch('close')">
                                            {{ __('Cancel') }}
                                        </button>

                                        <button type="submit" class="btn btn-danger rounded-pill px-4 fw-bold shadow-sm">
                                            {{ __('Delete Account') }}
                                        </button>
                                    </div>
                                </form>
                            </x-modal>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
