
<x-mail::message>
# Hi {{ $firstName }}!

**{{ $commenterName }}** commented on your InstaNest post.

> {{ $commentBody }}

<x-mail::button :url="$postUrl">
View Comment
</x-mail::button>

Regards,  
The InstaNest Team
</x-mail::message>

