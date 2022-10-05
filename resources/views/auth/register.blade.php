@extends('auth.layouts.app')

@section('content')

<body>
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="bg-primary bg-soft">
                            <div class="row">
                                <div class="col-7">
                                    <div class="text-primary p-4">
                                        <h5 class="text-primary">Free Register</h5>
                                        <p>Get your free Surseco Online Billing account now.</p>
                                    </div>
                                </div>
                                <div class="col-5 align-self-end">
                                    <img src="assets/images/profile-img.png" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div>
                                <a href="/">
                                    <div class="avatar-md profile-user-wid mb-4">
                                        <span class="avatar-title rounded-circle bg-light">
                                            <img src="assets/images/logo.svg" alt="" class="rounded-circle" height="34">
                                        </span>
                                    </div>
                                </a>
                            </div>
                            <div class="p-2">
                                <form class="needs-validation" action="{{ route('register') }}" method="POST">
                                    @csrf
                                    <div class="mb-2">
                                        <label for="accountNo" class="form-label">Account Number</label>
                                        <input type="text" class="form-control" id="accountNo" name="AccountNumber" placeholder="Enter Your Account Number" required>
                                    </div>
                                    <div class="mb-2">
                                        <label for="firstname" class="form-label">Firstname</label>
                                        <input type="text" class="form-control" id="firstname" name="FirstName" placeholder="Enter First Name" required>
                                    </div>
                                    <div class="mb-2">
                                        <label for="middlename" class="form-label">Middlename</label>
                                        <input type="text" class="form-control" id="middlename" name="MiddleName" placeholder="Enter Middle Name" required>
                                    </div>
                                    <div class="mb-2">
                                        <label for="lastname" class="form-label">Lastname</label>
                                        <input type="text" class="form-control" id="lastname" name="LastName" placeholder="Enter Last Name" required>
                                    </div>

                                    <div class="mb-2">
                                        <label for="useremail" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="useremail" name="Email" placeholder="Enter email" required>
                                    </div>

                                    <div class="mb-2">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" required>
                                    </div>

                                    <div class="mb-2">
                                        <label for="userpassword" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="userpassword" name="password" placeholder="Enter password" required>
                                        <div class="invalid-feedback">
                                            Please Enter Password
                                        </div>
                                    </div>

                                    <div class="mt-4 d-grid">
                                        <button class="btn btn-primary waves-effect waves-light" type="submit">Register</button>
                                    </div>


                                    <div class="mt-4 text-center">
                                        <p class="mb-0">By registering you agree to our <a href="#" class="text-primary">Terms of Use</a></p>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                    <div class="mt-5 text-center">

                        <div>
                            <p>Already have an account ? <a href="{{ route('login') }}" class="fw-medium text-primary"> Login</a> </p>
                            <p>© <script>
                                    document.write(new Date().getFullYear())
                                </script> Surseco Online Billing</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- end account-pages -->

    <!-- JAVASCRIPT -->
<script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <!-- App js -->
    <script src="{{ asset('assets/js/app.js') }}"></script>
</body>
@endsection
