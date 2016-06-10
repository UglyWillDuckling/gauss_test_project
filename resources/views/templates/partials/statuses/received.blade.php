<p>
    friend request received from {{ $user->username }}
    <a href="{{ route('friends.accept', ['username', $user->username]) }}" class="btn btn-primary">accept</a>
</p>