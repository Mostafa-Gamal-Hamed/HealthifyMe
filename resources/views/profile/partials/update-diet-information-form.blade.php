<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Diet Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Update your diet information to create a diet that works for you.') }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.diet') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div class="mb-3">
            <x-input-label for="gender" :value="__('Gender')" />
            <select name="gender" id="gender" class="form-select">
                <option value="{{ old('gender', $user->dietInfo ? $user->dietInfo->gender : '') }}" hidden>{{ old('gender', $user->dietInfo ? $user->dietInfo->gender : '') }}</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('gender')" />
        </div>

        <div>
            <x-input-label for="age" :value="__('Age')" />
            <x-text-input id="age" name="age" type="number" class="mt-1 block w-full" :value="old('age', $user->dietInfo ? $user->dietInfo->age : '')"
                required />
            <x-input-error class="mt-2" :messages="$errors->get('age')" />
        </div>

        <div>
            <x-input-label for="weight" :value="__('Weight')" />
            <x-text-input id="weight" name="weight" type="number" class="mt-1 block w-full" :value="old('weight', $user->dietInfo ? $user->dietInfo->weight : '')"
                step="0.01" required />
            <x-input-error class="mt-2" :messages="$errors->get('weight')" />
        </div>

        <div>
            <x-input-label for="height" :value="__('Height')" />
            <x-text-input id="height" name="height" type="number" class="mt-1 block w-full" :value="old('height', $user->dietInfo ? $user->dietInfo->height : '')"
                step="0.01" required />
            <x-input-error class="mt-2" :messages="$errors->get('height')" />
        </div>

        <div>
            <x-input-label for="activity_level" :value="__('Activity level')" />
            <select name="activity_level" id="activity_level" class="form-select">
                <option value="{{ old('activity_level', $user->dietInfo ? $user->dietInfo->activity_level : '') }}" hidden>{{ old('activity_level', $user->dietInfo ? $user->dietInfo->activity_level : '') }}</option>
                <option value="low">Low</option>
                <option value="moderate">Moderate</option>
                <option value="high">High</option>
                <option value="professional">Professional</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('activity_level')" />
        </div>

        <div>
            <x-input-label for="workout_hours_per_week" :value="__('Workout hours per week')" />
            <x-text-input id="workout_hours_per_week" name="workout_hours_per_week" type="number"
                class="mt-1 block w-full" :value="old('workout_hours_per_week', $user->dietInfo ? $user->dietInfo->workout_hours_per_week : '')" required />
            <x-input-error class="mt-2" :messages="$errors->get('workout_hours_per_week')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
