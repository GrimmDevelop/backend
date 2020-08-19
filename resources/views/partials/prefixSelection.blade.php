<div class="col-md-12 letters-container">
    <ul class="letters">
        @foreach($navigationPrefixes as $letter => $_)
            <li class="{{ active($firstCharacter, $letter) }}">
                <a href="{{ url()->filtered(['prefix' => $letter]) }}">{{ $letter }}</a>
            </li>
        @endforeach
        @if($firstCharacter)
            <li>
                <a href="{{ url()->filtered(['-prefix']) }}">&times;</a>
            </li>
        @endif
    </ul>
</div>
@if($firstCharacter)
    <div class="col-md-12 letters-container">
        <ul class="letters">
            @foreach($navigationPrefixes[$firstCharacter] as $letter)
                <li class="{{ active($secondCharacter, $letter) }}">
                    <a href="{{ url()->filtered(['prefix' => $firstCharacter . $letter]) }}">{{ $firstCharacter . $letter }}</a>
                </li>
            @endforeach
            @if($secondCharacter)
                <li>
                    <a href="{{ url()->filtered(['prefix' => $firstCharacter]) }}">&times;</a>
                </li>
            @endif
        </ul>
    </div>
@endif
