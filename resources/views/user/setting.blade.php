<x-layout.user>
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <x-nav />
            <div class="container-fluid">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Account Settings</h1>
                </div>
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Account Information</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" width="100%" cellspacing="0">
                                        <tr>
                                            <th>Full Name</th>
                                            <td>{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email Address</th>
                                            <td>{{ Auth::user()->email }}</td>
                                        </tr>
                                        <tr>
                                            <th>User Type</th>
                                            <td>{{ ucfirst(Auth::user()->role) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Date Joined</th>
                                            <td>{{ Auth::user()->created_at }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Updated Password</h6>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('user.update') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <input type="password" name="old_password" id="old-password"
                                            class="form-control" placeholder="Enter Current Password">
                                        @if ($errors->has('old_password'))
                                            <small class="text-danger">{{ $errors->first('old_password') }}</small>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="new_password" id="new-password"
                                            class="form-control" placeholder="Enter New Password">
                                        @if ($errors->has('new_password'))
                                            <small class="text-danger">{{ $errors->first('new_password') }}</small>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="new_password_confirmation" id="confirm-password"
                                            class="form-control" placeholder="Re-type New Password">
                                    </div>
                                    <button class="btn btn-success">
                                        <i class="fas fa-save fa-sm fa-fw mr-2"></i>
                                        Save
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; Sales App by Randisoft {{ date('Y') }}</span>
                </div>
            </div>
        </footer>
    </div>
</x-layout.user>
