<?php

/**
 * Šis kontrolieris apstrādā "Admin Panel Controller" sadaļas pieprasījumus un lapas plūsmu.
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Calendar;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class AdminPanelController extends Controller
{
    /**
     * Šī metode sagatavo un attēlo galveno lapas vai saraksta skatu.
     */
    public function index(): View
    {
        $totalUsers = User::count();
        $totalPosts = Post::count();
        $totalEvents = Calendar::count();
        $totalComments = Comment::count();
        $totalAdmins = User::where('role', 'admin')->count();
        $totalSuperAdmins = User::where('role', 'super_admin')->count();
        $activeUsers = User::where('updated_at', '>=', now()->subDays(30))->count();
        $recentPosts = Post::with('user')->latest()->paginate(3, ['*'], 'posts_page');
        $recentComments = Comment::with(['user', 'post'])->latest()->paginate(4, ['*'], 'comments_page');

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalPosts',
            'totalEvents',
            'totalComments',
            'totalAdmins',
            'totalSuperAdmins',
            'activeUsers',
            'recentPosts',
            'recentComments'
        ));
    }

    /**
     * Šī metode apstrādā darbību "comments" un atgriež atbilstošu rezultātu.
     */
    public function comments(): View
    {
        $comments = Comment::with(['user', 'post'])->latest()->paginate(10);

        return view('admin.comments.index', compact('comments'));
    }

    /**
     * Šī metode apstrādā darbību "comments Delete" un atgriež atbilstošu rezultātu.
     */
    public function commentsDelete(Comment $comment): RedirectResponse
    {
        $comment->delete();

        return redirect()->route('admin.comments')->with('success', 'Comment deleted successfully');
    }

    /**
     * Šī metode apstrādā darbību "administrators" un atgriež atbilstošu rezultātu.
     */
    public function administrators(): View
    {
        $administrators = User::whereIn('role', ['admin', 'super_admin'])->latest()->paginate(10);

        return view('admin.administrators.index', compact('administrators'));
    }

    /**
     * Šī metode apstrādā darbību "users" un atgriež atbilstošu rezultātu.
     */
    public function users()
    {
        $users = User::paginate(10);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Šī metode apstrādā darbību "users Show" un atgriež atbilstošu rezultātu.
     */
    public function usersShow(User $user)
    {
        $subscriptions = collect();
        $subscriptionsCount = 0;

        if (Schema::hasTable('subscriptions')) {
            $subscriptions = $user->subscriptions()->get();
            $subscriptionsCount = $subscriptions->count();
        }

        return view('admin.users.show', compact('user', 'subscriptions', 'subscriptionsCount'));
    }

    /**
     * Šī metode apstrādā darbību "users Edit" un atgriež atbilstošu rezultātu.
     */
    public function usersEdit(User $user)
    {
        if ($user->isSuperAdmin() && ! auth()->user()->isSuperAdmin()) {
            abort(403);
        }

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Šī metode apstrādā darbību "users Update" un atgriež atbilstošu rezultātu.
     */
    public function usersUpdate(Request $request, User $user)
    {
        if ($user->isSuperAdmin() && ! auth()->user()->isSuperAdmin()) {
            abort(403);
        }

        $allowedRoles = auth()->user()->isSuperAdmin()
            ? 'in:user,admin,super_admin'
            : 'in:user,admin';

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|'.$allowedRoles,
        ]);

        if (! auth()->user()->isSuperAdmin() && isset($validated['role']) && $validated['role'] !== $user->role) {
            unset($validated['role']);
        }

        $user->update($validated);

        return redirect()->route('admin.users')->with('success', 'User updated successfully');
    }

    /**
     * Šī metode apstrādā darbību "users Delete" un atgriež atbilstošu rezultātu.
     */
    public function usersDelete(User $user)
    {
        if ($user->isSuperAdmin()) {
            abort(403);
        }

        $user->delete();

        return redirect()->route('admin.users')->with('success', 'User deleted successfully');
    }

    /**
     * Šī metode apstrādā darbību "posts" un atgriež atbilstošu rezultātu.
     */
    public function posts()
    {
        $posts = Post::with('user')->paginate(10);

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Šī metode apstrādā darbību "posts Delete" un atgriež atbilstošu rezultātu.
     */
    public function postsDelete(Post $post)
    {
        $post->delete();

        return redirect()->route('admin.posts')->with('success', 'Post deleted successfully');
    }

    /**
     * Šī metode apstrādā darbību "events" un atgriež atbilstošu rezultātu.
     */
    public function events()
    {
        $events = Calendar::with('user')->paginate(10);

        return view('admin.events.index', compact('events'));
    }

    /**
     * Šī metode apstrādā darbību "events Delete" un atgriež atbilstošu rezultātu.
     */
    public function eventsDelete(Calendar $event)
    {
        $event->delete();

        return redirect()->route('admin.events')->with('success', 'Event deleted successfully');
    }

    /**
     * Šī metode apstrādā darbību "statistics" un atgriež atbilstošu rezultātu.
     */
    public function statistics(): View
    {
        $totalUsers = User::count();
        $activeUsers = User::where('updated_at', '>=', now()->subDays(30))->count();
        $userStats = $this->buildMonthlyStats(User::class);
        $postStats = $this->buildMonthlyStats(Post::class);

        return view('admin.statistics', compact(
            'totalUsers',
            'activeUsers',
            'userStats',
            'postStats'
        ));
    }

    /**
     * Build monthly statistics for chart.js.
     *
     * @param  class-string  $modelClass
     * @return array<int, array{month:int, count:int}>
     */
    private function buildMonthlyStats(string $modelClass): array
    {
        $year = now()->year;

        $counts = $modelClass::query()
            ->whereYear('created_at', $year)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month');

        return collect(range(1, 12))
            ->map(static fn (int $month): array => [
                'month' => $month,
                'count' => (int) ($counts[$month] ?? 0),
            ])
            ->all();
    }
}
