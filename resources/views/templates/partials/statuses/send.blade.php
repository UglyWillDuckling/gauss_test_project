<p>
    send a friend request to {{ $user->username }}.
    <a href="{{ route('friends.add', [$user->username]) }}" class="btn btn-primary">send request</a>
</p>