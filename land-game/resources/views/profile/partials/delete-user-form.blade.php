<section>
    <header class="mb-4">
        <h2 class="h5 fw-bold mb-2">حذف الحساب</h2>
        <p class="text-muted small mb-0">بمجرد حذف حسابك، سيتم حذف جميع موارده وبياناته نهائياً. قبل حذف حسابك، يرجى تنزيل أي بيانات أو معلومات ترغب في الاحتفاظ بها.</p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="btn btn-danger"
    >{{ __('حذف الحساب') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-4">
            @csrf
            @method('delete')

            <h2 class="h5 fw-bold mb-3">
                {{ __('هل أنت متأكد من حذف حسابك؟') }}
            </h2>

            <p class="text-muted small mb-4">
                {{ __('بمجرد حذف حسابك، سيتم حذف جميع موارده وبياناته نهائياً. يرجى إدخال كلمة المرور لتأكيد رغبتك في حذف حسابك نهائياً.') }}
            </p>

            <div class="mb-4">
                <x-input-label for="password" value="{{ __('كلمة المرور') }}" class="visually-hidden" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="form-control"
                    placeholder="{{ __('كلمة المرور') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-1" />
            </div>

            <div class="d-flex justify-content-end gap-2">
                <x-secondary-button x-on:click="$dispatch('close')" class="btn btn-secondary">
                    {{ __('إلغاء') }}
                </x-secondary-button>

                <x-danger-button class="btn btn-danger">
                    {{ __('حذف الحساب') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
