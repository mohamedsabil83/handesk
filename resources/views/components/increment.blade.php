@if( $value > 0)
    <span class="green fs1">( @icon(arrow-up fas) {{ number_format($value,0) }} % )</span>
@else
    <span class="red fs1">( @icon(arrow-down fas) {{ number_format($value* -1,0) }} % )</span>
@endif
