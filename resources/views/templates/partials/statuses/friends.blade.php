    <p>
        you and {{ $user->username }} are friends.
        <a href="{{ route('friends.delete', [$user->username]) }}" class="btn btn-primary">unfriend</a>
    </p>