@php $editing = isset($transaction) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="order_id" label="Order" required>
            @php $selected = old('order_id', ($editing ? $transaction->order_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Order</option>
            @foreach($orders as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.number
            name="amount"
            label="Amount"
            :value="old('amount', ($editing ? $transaction->amount : ''))"
            max="255"
            step="0.01"
            placeholder="Amount"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.date
            name="date"
            label="Date"
            value="{{ old('date', ($editing ? optional($transaction->date)->format('Y-m-d') : '')) }}"
            max="255"
            required
        ></x-inputs.date>
    </x-inputs.group>
</div>
