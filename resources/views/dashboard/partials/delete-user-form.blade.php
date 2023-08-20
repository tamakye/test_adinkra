<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>


    <button type="button" class="btn btn-primary bg-danger border-0" data-bs-toggle="modal" data-bs-target="#deleteModal">
      Delete Account
  </button>


  <!-- Modal -->
  <div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLabel">Modal title</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            <div class="modal-body">
                @csrf
                @method('delete')

                <h2 class="text-lg font-medium text-gray-900">
                    {{ __('Are you sure you want to delete your account?') }}
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                </p>

                <div class="mt-3">
                    <x-input-label for="password" value="Password" class="sr-only" />

                    <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block form-control w-3/4"
                    placeholder="Password"
                    />

                    <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-danger" />
                    </div>

                    <div class="mt-3 flex justify-end">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Cancel</button>

                        <button type="submit" class="btn bg-danger text-white ms-3">Delete Account</button>

                    </div>

                </div>
               {{--  <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Delete Account</button>
                </div> --}}
            </form>
        </div>
    </div>
</div>


</section>
