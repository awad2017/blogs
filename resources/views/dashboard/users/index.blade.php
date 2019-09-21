@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h3>@lang('site.dashboard')</h3>

            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.index') }}"> @lang('site.dashboard')</a> </li>
                <li class="active">@lang('site.users')</li>
            </ol>
        </section>
        <section class="content">

            <div class="box box-primary">

                <div class="box-header">
                    <h3 class="box-title">@lang('site.users') <small>(" {{ $users->total() }} ")</small></h3>
                    <form class="form-search" action="{{ route('dashboard.users.index') }}" method="get">
                        <div class="row">
                            <div class="col-md-4">
                                <input class="form-control" type="text" name="search" placeholder="@lang('site.search')" value="{{ request()->search }}">
                            </div>
                            <div class="col-md-4">
                              <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> @lang('site.search')</button>
                             @if (auth()->user()->hasPermission('create_users'))
                                    <a class="btn btn-primary" href="{{ route('dashboard.users.create') }}"><i class="fa fa-plus"></i> @lang('site.create') </a>
                             @else
                                 <a class="btn btn-primary disabled" href="#"><i class="fa fa-plus"></i> @lang('site.create') </a>
                             @endif
                            </div>
                        </div>
                    </form>
                </div>
                <div class="box-body">
                @if ($users->count() > 0)
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('site.name')</th>
                                <th>@lang('site.email')</th>
                                <th>@lang('site.image')</th>
                                <th>@lang('site.action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($users as $index => $user)
                              <tr>
                                  <td>{{ $index + 1 }}</td>
                                  <td>{{ $user->name }}</td>
                                  <td>{{ $user->email }}</td>
                                  <td><img src="{{ $user->image_path }}" style="width: 100px" class="img-thumbnail" alt="this is image user"></td>
                                  <td>
                                      @if (auth()->user()->hasPermission('update_users'))
                                          <a href="{{ route('dashboard.users.edit', $user->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> @lang('site.edit')</a>

                                      @else
                                          <a href="#" class="btn btn-info btn-sm disabled"><i class="fa fa-edit"></i> @lang('site.edit')</a>

                                      @endif
                                    @if (auth()->user()->hasPermission('delete_users'))
                                     <form action="{{ route('dashboard.users.destroy', $user->id) }}" method="post">
                                         @csrf
                                         {{ method_field('delete') }}
                                         <button class="btn btn-danger delete btn-sm"><i class="fa fa-trash"></i> @lang('site.delete')</button>
                                     </form>
                                   @else
                                     <button class="btn btn-danger btn-sm disabled"><i class="fa fa-trash"></i> @lang('site.delete')</button>
                                   @endif
                                  </td>
                              </tr>
                            @endforeach
                            </tbody>

                        </table>
                        {{ $users->appends(request()->query())->links() }}
                    @else
                    <h3>@lang('site.no_data_found')</h3>
                @endif
                </div>
                <!-- /.box-body -->
            </div>

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->


@endsection

