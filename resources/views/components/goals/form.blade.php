@props(['goal' => null, 'statuses'])

<div>
    <div class="mb-4">
        <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
        <input type="text" name="title" id="title" value="{{ old('title', $goal?->title) }}"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('title') border-red-500 @enderror"
            required minlength="3" maxlength="255">
        @error('title')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-4">
        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
        <textarea name="description" id="description" rows="3"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('description') border-red-500 @enderror"
            maxlength="1000">{{ old('description', $goal?->description) }}</textarea>
        <p class="mt-1 text-sm text-gray-500">Maximum 1000 characters</p>
        @error('description')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    @if(auth()->user()->isSuperAdmin())
        <div class="mb-4">
            <label for="team_id" class="block text-sm font-medium text-gray-700">Team</label>
            <select name="team_id" id="team_id"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('team_id') border-red-500 @enderror"
                required>
                @foreach(\App\Models\Team::all() as $team)
                    <option value="{{ $team->id }}" {{ old('team_id', $goal?->team_id) == $team->id ? 'selected' : '' }}>
                        {{ $team->name }}
                    </option>
                @endforeach
            </select>
            @error('team_id')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>
    @endif

    @if(auth()->user()->isTeamLead() || auth()->user()->isSuperAdmin())
        <div class="mb-4">
            <label for="assigned_to" class="block text-sm font-medium text-gray-700">Assign To</label>
            <select name="assigned_to" id="assigned_to"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('assigned_to') border-red-500 @enderror">
                <option value="">Unassigned</option>
                @foreach(auth()->user()->isSuperAdmin() ? \App\Models\User::role('team-member')->get() : auth()->user()->team->users()->role('team-member')->get() as $member)
                    <option value="{{ $member->id }}" {{ old('assigned_to', $goal?->assigned_to) == $member->id ? 'selected' : '' }}>
                        {{ $member->name }}
                    </option>
                @endforeach
            </select>
            @error('assigned_to')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>
    @endif

    <div class="mb-4">
        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
        <select name="status" id="status"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('status') border-red-500 @enderror"
            required>
            @foreach($statuses as $value => $label)
                <option value="{{ $value }}" {{ old('status', $goal?->status) == $value ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        @error('status')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-4">
        <label for="due_date" class="block text-sm font-medium text-gray-700">Due Date</label>
        <input type="date" name="due_date" id="due_date" value="{{ old('due_date', optional($goal?->due_date)->format('Y-m-d')) }}"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('due_date') border-red-500 @enderror"
            required min="{{ now()->format('Y-m-d') }}">
        @error('due_date')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex justify-end gap-4">
        <a href="{{ route('goals.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
            Cancel
        </a>
        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
            {{ $goal ? 'Update Goal' : 'Create Goal' }}
        </button>
    </div>
</div> 