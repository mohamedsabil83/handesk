@if($ticket->rating)
    @for($i = 0; $i < 5; $i++)
        @if($ticket->rating > $i)
            @icon(star fas)
        @else
            @icon(star-o fas)
        @endif
    @endfor
@endif
