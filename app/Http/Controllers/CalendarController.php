<?php

namespace App\Http\Controllers;

use App\Models\Calendar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CalendarController extends Controller
{

    public function index()
    {
        return view('activity-calendar.index');
    }

    public function store(Request $request)
    {
        $customType = trim((string) $request->input('custom_type', ''));
        $requestedType = (string) $request->input('type', '');
        $allowedTypes = [...Calendar::PRESET_TYPES, 'custom'];

        if ($customType !== '' && $requestedType !== '' && ! in_array($requestedType, $allowedTypes, true)) {
            $request->merge([
                'type' => 'custom',
                'custom_type' => $customType,
            ]);
        }

        $validated = $request->validate([
            'date' => ['required', 'date'],
            'type' => ['required', Rule::in($allowedTypes)],
            'custom_type' => ['nullable', 'string', 'max:30', 'required_if:type,custom'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        $event = Calendar::create([
            'user_id' => Auth::id(),
            'date' => Carbon::parse($validated['date'])->toDateString(),
            'type' => $validated['type'],
            'custom_type' => $validated['type'] === 'custom'
                ? trim((string) $validated['custom_type'])
                : null,
            'description' => $validated['description'],
            'completed' => false,
        ]);

        return response()->json([
            'success' => true,
            'event' => [
                'id' => $event->id,
                'start' => $event->date,
                'title' => $event->display_type.': '.($event->description ?? __('calendar.no_description')),
                'type' => $event->type,
                'type_label' => $event->display_type,
                'custom_type' => $event->custom_type,
                'description' => $event->description,
                'completed' => $event->completed,
            ],
        ]);
    }

    public function update(Request $request, $id)
    {
        $calendar = Calendar::findOrFail($id);

        if ($calendar->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'completed' => 'required|boolean',
        ]);

        $calendar->update($validated);

        return response()->json(['success' => true]);
    }

    public function getEvents(Request $request)
    {
        $start = $request->query('start', Carbon::today()->toDateString());
        $end = $request->query('end', Carbon::today()->addDays(30)->toDateString());

        $events = Calendar::where('user_id', Auth::id())
            ->whereBetween('date', [$start, $end])
            ->get()
            ->map(function ($event) {
                return [
                    'id' => $event->id,
                    'start' => $event->date->toDateString(),
                    'title' => $event->display_type.': '.($event->description ?? __('calendar.no_description')),
                    'type' => $event->type,
                    'type_label' => $event->display_type,
                    'custom_type' => $event->custom_type,
                    'description' => $event->description,
                    'completed' => $event->completed,
                ];
            });

        return response()->json($events);
    }

    public function destroy($id)
    {
        $calendar = Calendar::findOrFail($id);

        if ($calendar->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $calendar->delete();

        return response()->json(['success' => true]);
    }
}
