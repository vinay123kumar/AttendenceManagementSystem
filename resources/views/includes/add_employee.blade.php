<!-- Add New Employee Modal -->
<div class="modal fade" id="addnew" tabindex="-1" role="dialog" aria-labelledby="addnewLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addnewLabel"><b>Add New Employee</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <!-- Display flash message -->
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('employees.store') }}" id="employeeForm">
                    @csrf
                    <!-- Form Group -->
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" placeholder="Enter an Employee name [hyphen accepted]" id="name" name="name" />
                        <!-- Validation Error Alert -->
                        @error('name')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="position">Position <i>{without any space}</i></label>
                        <input type="text" class="form-control" placeholder="Enter Employee's Position [hyphen accepted]" id="position" name="position"  />
                        <!-- Validation Error Alert -->
                        @error('position')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email"  />
                        <!-- Validation Error Alert -->
                        @error('email')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="schedule">Schedule</label>
                        <select class="form-control" id="schedule" name="schedule">
                            <option value="" selected>- Select -</option>
                            @foreach ($schedules as $schedule)
                                <option value="{{ $schedule->slug }}">{{ $schedule->slug }} -> from {{ $schedule->time_in }} to {{ $schedule->time_out }}</option>
                            @endforeach
                        </select>
                        <!-- Validation Error Alert -->
                        @error('schedule')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div>
                            <button type="submit" class="btn btn-success waves-effect waves-light">Submit</button>
                            <button type="reset" class="btn btn-danger waves-effect m-l-5" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for client-side validation -->
<script>
document.getElementById('employeeForm').addEventListener('submit', function(event) {
    var form = event.target;
    var name = form.querySelector('#name');
    var position = form.querySelector('#position');
    var email = form.querySelector('#email');
    var schedule = form.querySelector('#schedule');
    var isValid = true;

    // Reset previous error messages
    form.querySelectorAll('.alert-danger').forEach(function(alert) {
        alert.classList.add('d-none');
    });

    // Name validation
    if (name.value.trim() === '') {
        document.querySelector('#nameError').classList.remove('d-none');
        isValid = false;
    }

    // Add more validations as needed (e.g., position, email, schedule)

    if (!isValid) {
        event.preventDefault(); // Prevent form submission if validation fails
    }
});
</script>
