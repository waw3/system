@php
/**
 * @var string $value
 */
$value = isset($value) ? (array)$value : [];
@endphp
@if($procategories)
    <ul>
        @foreach($procategories as $procategory)
            @if($procategory->id != $currentId)
                <li value="{{ $procategory->id ?? '' }}"
                        {{ $procategory->id == $value ? 'selected' : '' }}>
                    {!! Form::customCheckbox([
                        [
                            $name, $procategory->id, $procategory->name, in_array($procategory->id, $value),
                        ]
                    ]) !!}
                    @include('modules.plugins.product::procategories.procategories-checkbox-option-line', [
                        'procategories' => $procategory->child_cats,
                        'value' => $value,
                        'currentId' => $currentId,
                        'name' => $name
                    ])
                </li>
            @endif
        @endforeach
    </ul>
@endif
