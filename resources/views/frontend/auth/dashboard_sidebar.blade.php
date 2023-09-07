<div class="col-md-3">
    <div class="list-group" id="list-tab" role="tablist">
        <a class="list-group-item list-group-item-action {{ request()->is('user/dashboard') ? 'active' : '' }}" id="list-home-list" data-toggle="list" href="{{ route('user.dashboard') }}">Profile</a>
        <a class="list-group-item list-group-item-action {{ request()->is('user/edit/profile') ? 'active' : '' }}" id="list-profile-list" data-toggle="list" href="{{ route('user.edit.profile') }}">Edit Profile</a>
        <a class="list-group-item list-group-item-action {{ request()->is('user/change/password') ? 'active' : '' }}" id="list-profile-list" data-toggle="list" href="{{ route('user.change.password') }}">Change Password</a>
        <a class="list-group-item list-group-item-action" id="list-settings-list" data-toggle="list" href="{{ route('user.logout') }}">Logout</a>
    </div>
</div>
