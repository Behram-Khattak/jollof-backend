You have been invited to join team {{$team->name}}.<br>
Click here to join: <a href="{{route('merchant.teams.accept_invite', $invite->accept_token)}}">{{route('merchant.teams.accept_invite', $invite->accept_token)}}</a>
