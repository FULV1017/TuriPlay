# Public Videos Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Let visitors browse and play opted-in public videos, while registered users can like and comment publicly.

**Architecture:** Keep local video files private and expose only opted-in streaming through the existing controller. Add a public video index/detail with Blade using the established landing visual language; keep uploading, publishing and moderation ownership in Filament. Use relational likes/comments and server-side form actions with authentication and CSRF.

**Tech Stack:** Laravel 13, Filament 5, SQLite, Blade, CSS, PHPUnit.

**Spec:** Conversation with user (2026-11-02): owner opts into publication; all visitors watch; registered users like/comment; comments visible immediately; landing links to a dedicated videos page.

## Global Constraints

- Videos already uploaded remain private by default; never expose a private file by guessing an ID.
- Anonymous visitors view public videos but must authenticate to react.
- Public pages retain Spanish copy and existing TuriPlay visual identity.
- Authenticated users can also visit public pages; downloading remains owner/admin only.

## Review Focus

- Existing video without publication flag stays private, including guessed stream URLs (Task 1).
- Guest attempts to like/comment must not create data (Task 2).
- Another user's private video must not be visible through listing, detail or stream (Task 1).
- Duplicate likes cannot inflate totals and can be toggled off (Task 2).
- Deleted/unpublished videos leave no public comments or reactions accessible (Tasks 1-2).

---

### Task 1: Publishing and public viewing

**Files:** `database/migrations/*_add_is_public_to_videos_table.php`, `app/Models/Video.php`, `app/Policies/VideoPolicy.php`, `app/Http/Controllers/VideoStreamController.php`, `app/Http/Controllers/PublicVideoController.php`, `routes/web.php`, `app/Filament/Resources/Videos/Schemas/VideoForm.php`, `tests/Feature/PublicVideoTest.php`.

**Interfaces:** `Video::scopePublic(Builder $query): Builder`; public routes `public-videos.index` and `public-videos.show`; `VideoStreamController::stream(Video $video)` retains existing route; `videos.download` retains owner/admin restriction.

- [x] Add failing feature tests for private-by-default, opt-in publishing by owner, public listing/detail/stream, guessed private IDs, download remains forbidden.
- [x] Run `php artisan test tests/Feature/PublicVideoTest.php` and confirm expected failure.
- [x] Add schema, model scope/cast, Filament owner publication control, policy and stream branch, index/detail controller/routes.
- [x] Re-run feature tests and `composer test` until green.

### Task 2: Likes and comments

**Files:** `database/migrations/*_create_video_likes_table.php`, `database/migrations/*_create_video_comments_table.php`, `app/Models/VideoLike.php`, `app/Models/VideoComment.php`, `app/Models/Video.php`, `app/Http/Controllers/VideoInteractionController.php`, `routes/web.php`, `tests/Feature/PublicVideoInteractionTest.php`.

**Interfaces:** authenticated POST `public-videos.like` toggles a unique `(user_id,video_id)` like; authenticated POST `public-videos.comments.store` validates message and creates a public comment only on a public video. Public detail retrieves comments and counts.

- [x] Add failing tests for guest, private, authenticated like toggle and unique count, comment validation, published comment visibility, unpublishing.
- [x] Run `php artisan test tests/Feature/PublicVideoInteractionTest.php` and confirm expected failures.
- [x] Add migrations, models, relationships, interaction controller and rate-limited routes.
- [x] Re-run feature tests and `composer test` until green.

### Task 3: Visitor-facing pages

**Files:** `resources/views/landing.blade.php`, `resources/views/public-videos/index.blade.php`, `resources/views/public-videos/show.blade.php`, `resources/views/public-videos/partials/header.blade.php`, `resources/css/landing.css`, `tests/Feature/PublicVideoTest.php`, `tests/Feature/PublicVideoInteractionTest.php`.

**Interfaces:** landing entry to `public-videos.index`; index paginated; detail plays `videos.stream` and shows public comments, like count and login/register prompt for guests; existing landing style extended, no public downloads.

- [x] Add failing tests for navigation, empty state, pagination and displayed interactions.
- [x] Run targeted tests and confirm failure.
- [x] Build accessible responsive Blade/CSS for index/detail and link landing to gallery; remove outdated privacy copy.
- [x] Run `composer test`, `npm run build`, and formatting check; report results.

## Rulings

- Existing uncommitted landing and panel files are preserved in-place on a new feature branch; a fresh worktree would omit those untracked files.
- Existing `VideoPolicy::view()` stays owner/admin-only for private records; only the stream controller explicitly allows anonymously streaming public records. Downloads stay gated by the original policy.
- The user's final direction replaced landing video previews with a prominent link to the paginated `/explorar` gallery.
- No automatic comment approval was added because the user requested immediate public visibility; comments are rate-limited and HTML-escaped.
