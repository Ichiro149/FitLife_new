@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/create.css') }}" rel="stylesheet">
@endsection

@section('content')
<div id="fitlife-container" role="application" aria-label="FitLife Edit Goal">
  <!-- Main Content -->
  <main>
    <!-- Mobile Menu Toggle -->
    <button id="mobile-toggle" aria-controls="sidebar" aria-expanded="false">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
        <path d="M4 6h16M4 12h16M4 18h16" />
      </svg>
    </button>

    <!-- Page Header -->
    <header>
      <div class="header-left">
        <h1><span>FitLife</span> Edit Goal</h1>
        <p class="muted">Update your goal details</p>
      </div>
    </header>

    <!-- Goal Form Section -->
    <section aria-labelledby="goal-form-heading">
      <h3 id="goal-form-heading">Edit Goal</h3>
      <div class="goal-card">
        <form action="{{ route('goals.update', $goal) }}" method="POST" class="goal-form">
          @csrf
          @method('PATCH')
          <div class="form-group">
            <label for="type">Goal Type</label>
            <select id="type" name="type" required>
              <option value="">Select goal</option>
              <option value="steps" {{ $goal->type === 'steps' ? 'selected' : '' }}>Steps</option>
              <option value="calories" {{ $goal->type === 'calories' ? 'selected' : '' }}>Calories</option>
              <option value="sleep" {{ $goal->type === 'sleep' ? 'selected' : '' }}>Sleep (hours)</option>
              <option value="weight" {{ $goal->type === 'weight' ? 'selected' : '' }}>Weight (kg)</option>
            </select>
          </div>

          <div class="form-group">
            <label for="target_value">Target Value</label>
            <input type="number" id="target_value" name="target_value" step="0.01" value="{{ old('target_value', $goal->target_value) }}" placeholder="Enter target value" required>
          </div>

          <div class="form-group">
            <label for="end_date">End Date</label>
            <input type="date" id="end_date" name="end_date" value="{{ old('end_date', $goal->end_date?->format('Y-m-d')) }}" required>
          </div>

          <div class="form-group">
            <label for="description">Description (optional)</label>
            <textarea id="description" name="description" rows="3" placeholder="Add a description">{{ old('description', $goal->description) }}</textarea>
          </div>

          <div class="form-actions" style="display: flex; gap: 10px;">
            <button type="submit" class="calculate-btn">Update Goal</button>
            <a href="{{ route('goals.index') }}" class="calculate-btn" style="background: #666; text-decoration: none; text-align: center;">Cancel</a>
          </div>
        </form>

        <!-- Delete Form -->
        <form action="{{ route('goals.destroy', $goal) }}" method="POST" style="margin-top: 20px;" onsubmit="return confirm('Are you sure you want to delete this goal?');">
          @csrf
          @method('DELETE')
          <button type="submit" class="calculate-btn" style="background: #dc3545; width: 100%;">Delete Goal</button>
        </form>
      </div>
    </section>
  </main>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('js/create.js') }}"></script>
@endsection
