{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<x-backpack::menu-item title="Users" icon="la la-question" :link="backpack_url('user')" />
<x-backpack::menu-item title="Movies" icon="la la-question" :link="backpack_url('movie')" />
<x-backpack::menu-item title="Genres" icon="la la-question" :link="backpack_url('genre')" />
<x-backpack::menu-item title="Shows" icon="la la-question" :link="backpack_url('show')" />