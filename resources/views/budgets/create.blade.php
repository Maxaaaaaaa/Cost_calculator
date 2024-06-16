@extends('layouts.app')

@section('title', 'Add Budget')

@section('content')
    <div class="container">
        <h1>Add Budget</h1>
        <form action="{{ route('budgets.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="amount" class="form-label">Amount</label>
                <input type="number" name="amount" id="amount" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="period" class="form-label">Period</label>
                <select name="period" id="period" class="form-select" required>
                    <option value="monthly">Monthly</option>
                    <option value="yearly">Yearly</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Add Budget</button>
        </form>
    </div>
@endsection
