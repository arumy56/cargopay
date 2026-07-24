<div class="row justify-content-end">
    <div class="col-12 col-md-7 col-lg-5 col-xl-4">
        <section class="quick-links card border-0">
            <h2><span>▦</span> Quick links</h2>
            <button type="button" data-dialog-open="organization-dialog"><span>▤</span> My Organization</button>
            <button type="button" data-dialog-open="profile-dialog"><span>◉</span> My Profile</button>
            @if(auth()->user()->isSuperuser())
                <a href="{{ route('subuser.index') }}"><span>♟</span> Manage Users</a>
            @endif
        </section>
    </div>
</div>
