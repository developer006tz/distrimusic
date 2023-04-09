@php $editing = isset($socialMediaPlatform) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="name"
            label="Name"
            :value="old('name', ($editing ? $socialMediaPlatform->name : ''))"
            maxlength="255"
            placeholder="Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="status" label="Status">
            @php $selected = old('status', ($editing ? $socialMediaPlatform->status : '1')) @endphp
            <option value="1" {{ $selected == '1' ? 'selected' : '' }} >1</option>
            <option value="0" {{ $selected == '0' ? 'selected' : '' }} >0</option>
        </x-inputs.select>
    </x-inputs.group>
</div>
