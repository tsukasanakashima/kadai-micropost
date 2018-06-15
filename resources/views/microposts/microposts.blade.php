<ul class="media-list">
@foreach ($microposts as $micropost)
    <?php $user = $micropost->user; ?>
    <li class="media">
        <div class="media-left">
            <img class="media-object img-rounded" src="{{ Gravatar::src($user->email, 50) }}" alt="">
        </div>
        <div class="media-body">
            <div>
                {!! link_to_route('users.show', $user->name, ['id' => $user->id]) !!} <span class="text-muted">posted at {{ $micropost->created_at }}</span>
            </div>
            <div>
                <p>{!! nl2br(e($micropost->content)) !!}</p>
            </div>
            <div class="btn-toolbar">
              <div class="btn-group">
                @if (Auth::user()->is_favorites($micropost->id))
                {!! Form::open(['route' => ['micropost.unfavorite', $micropost->id], 'method' => 'delete']) !!}
                    {!! Form::submit('unfavorite', ['class' => 'btn btn-warning btn-xs']) !!}
                {!! Form::close() !!}
            @else
                {!! Form::open(['route' => ['micropost.favorite', $micropost->id]]) !!}
                    {!! Form::submit('favorite', ['class' => "btn btn-primary btn-xs"]) !!}
                {!! Form::close() !!}
            @endif
              </div>
              <div class="btn-group">
                {!! Form::open(['route' => ['microposts.destroy', $micropost->id], 'method' => 'delete']) !!}
                     {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-xs']) !!}
                {!! Form::close() !!}
              </div>
              
            </div>
           
        </div>
    </li>
@endforeach
</ul>
{!! $microposts->render() !!}