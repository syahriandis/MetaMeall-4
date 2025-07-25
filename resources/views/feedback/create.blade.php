<h1>Feedback Form</h1>
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<form action="{{ route('feedback.store') }}" method="POST">
    @csrf
    <div>
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" value="{{ old('name') }}">
        @error('name')
            <div style="color:red;">{{ $message }}</div>
        @enderror
    </div>
    <div>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}">
        @error('email')
            <div style="color:red;">{{ $message }}</div>
        @enderror
    </div>
    <div>
        <label for="message">Feedback:</label>
        <textarea name="message" id="message">{{ old('message') }}</textarea>
        @error('message')
            <div style="color:red;">{{ $message }}</div>
        @enderror
    </div>
    <button type="submit">Submit Feedback</button>
</form>