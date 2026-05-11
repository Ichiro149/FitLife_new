/* Šis skripts nodrošina "posts composer" publiskās saskarnes interaktivitāti. */

document.addEventListener('DOMContentLoaded', function() {
    const composerIsland = document.getElementById('composer-island');
    const composerForm = document.getElementById('post-form');
    const composerText = document.getElementById('composer-text');
    const composerContext = document.getElementById('composer-context');
    const composerContextText = document.getElementById('composer-context-text');
    const composerContextClose = document.getElementById('composer-context-close');
    const composerMode = document.getElementById('composer-mode');
    const composerPostId = document.getElementById('composer-post-id');
    const composerParentId = document.getElementById('composer-parent-id');
    const composerReplyToIdInput = document.getElementById('composer-reply-to-id');
    const composerTools = document.getElementById('composer-tools');
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

    if (!composerIsland || !composerForm || !composerText || !composerContext || !composerContextText || !composerContextClose || !composerMode || !composerPostId || !composerParentId || !composerReplyToIdInput || !csrfToken) {
        return;
    }

    const messages = window.postsComposerMessages || {};
    const message = (key, fallback) => messages[key] || fallback;
    const toastMessage = (key, fallback) => window.toastMessages?.[key] || fallback;

    const updateRepliesToggleLabel = (toggleBtn, expanded) => {
        if (!toggleBtn) {
            return;
        }

        const textEl = toggleBtn.querySelector('.replies-toggle-text');
        if (!textEl) {
            return;
        }

        const commentId = toggleBtn.dataset.commentId;
        const repliesEl = commentId ? document.getElementById('replies-' + commentId) : null;
        const total = Number(repliesEl?.dataset.total || textEl.textContent.match(/\d+/)?.[0] || 0);

        textEl.textContent = expanded
            ? message('collapseReplies', 'Hide replies')
            : message('viewReplies', ':count Replies').replace(':count', total);
    };

    const originalAction = composerForm.action;
    const originalPlaceholder = composerText.placeholder;
    let composerReplyToUser = '';

    // Auto-resize textarea
    if (composerText) {
        composerText.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = Math.min(this.scrollHeight, 120) + 'px';
        });

        composerText.style.height = 'auto';
        composerText.style.height = Math.min(composerText.scrollHeight, 120) + 'px';
    }

    // Emoji picker
    const trigger = document.querySelector('.emoji-trigger');
    const dropdown = document.querySelector('.emoji-dropdown');
    if (trigger && dropdown) {
        trigger.addEventListener('click', e => { e.stopPropagation(); dropdown.classList.toggle('open'); });
        document.addEventListener('click', () => dropdown.classList.remove('open'));
        dropdown.querySelectorAll('.emoji-btn').forEach(btn => {
            btn.addEventListener('click', e => {
                e.stopPropagation();
                if (composerText) {
                    composerText.value += btn.textContent;
                    composerText.focus();
                    composerText.dispatchEvent(new Event('input'));
                }
            });
        });
    }

    // === Composer Mode Switching ===
    function setComposerMode(mode, postId, parentId, contextLabel) {
        composerMode.value = mode;
        composerPostId.value = postId || '';
        composerParentId.value = parentId || '';

        if (mode === 'comment' || mode === 'reply') {
            composerIsland.classList.remove('mode-post', 'mode-comment', 'mode-reply');
            composerIsland.classList.add('mode-' + mode);
            composerContext.classList.add('is-active');
            composerContextText.textContent = contextLabel;
            composerForm.action = '/posts/' + postId + '/comment';
            composerText.placeholder = mode === 'reply' ? message('writeReply', 'Write a reply...') : message('writeComment', 'Write a comment...');
            composerText.setAttribute('maxlength', '500');
        } else {
            composerIsland.classList.remove('mode-comment', 'mode-reply');
            composerIsland.classList.add('mode-post');
            composerContext.classList.remove('is-active');
            composerForm.action = originalAction;
            composerText.placeholder = originalPlaceholder;
            composerText.setAttribute('maxlength', '1000');
            composerParentId.value = '';
            composerReplyToIdInput.value = '';
            composerReplyToUser = '';
        }
        composerText.focus();
    }

    // Cancel comment/reply mode
    composerContextClose.addEventListener('click', () => {
        setComposerMode('post');
        composerText.value = '';
        composerText.dispatchEvent(new Event('input'));
    });

    // Click "comment" button on post -> switch composer to comment mode
    document.addEventListener('click', e => {
        const commentToggle = e.target.closest('.comment-toggle');
        if (commentToggle) {
            const postId = commentToggle.dataset.postId;
            const postEl = document.getElementById('post-' + postId);
            const authorName = postEl?.querySelector('.post-author-name')?.textContent || '';
            setComposerMode('comment', postId, '', message('commentingOn', 'Commenting on') + ' ' + authorName);
            // Also still toggle the comments section
        }

        // Click "reply" button on a comment
        const replyBtn = e.target.closest('.reply-btn');
        if (replyBtn) {
            const commentId = replyBtn.dataset.commentId; // always root comment ID
            const replyToId = replyBtn.dataset.replyToId || ''; // actual comment being replied to
            const postId = replyBtn.dataset.postId;
            const replyToUser = replyBtn.dataset.replyToUser || '';
            const commentEl = document.getElementById('comment-' + commentId);
            const authorName = replyToUser || commentEl?.querySelector('.comment-author')?.textContent || '';
            composerReplyToUser = replyToUser;
            composerReplyToIdInput.value = replyToId;
            setComposerMode('reply', postId, commentId, message('replyingTo', 'Replying to') + ' @' + authorName);
            // Show replies section if hidden
            const repliesEl = document.getElementById('replies-' + commentId);
            if (repliesEl) repliesEl.style.display = 'block';
            // Update toggle text
            const toggleBtn = document.querySelector(`.replies-toggle[data-comment-id="${commentId}"]`);
            if (toggleBtn) {
                toggleBtn.classList.add('expanded');
                updateRepliesToggleLabel(toggleBtn, true);
            }
        }

        // Click "View N replies" toggle
        const repliesToggle = e.target.closest('.replies-toggle');
        if (repliesToggle) {
            const cid = repliesToggle.dataset.commentId;
            const repliesEl = document.getElementById('replies-' + cid);
            if (repliesEl) {
                const isVisible = repliesEl.style.display !== 'none';
                repliesEl.style.display = isVisible ? 'none' : 'block';
                repliesToggle.classList.toggle('expanded', !isVisible);
                updateRepliesToggleLabel(repliesToggle, !isVisible);
            }
        }

        // Click "Load more replies"
        const loadMoreBtn = e.target.closest('.replies-load-more');
        if (loadMoreBtn) {
            const cid = loadMoreBtn.dataset.commentId;
            const container = document.getElementById('replies-' + cid);
            if (!container) return;
            const hidden = [...container.querySelectorAll('.reply-extra')].filter(el => el.style.display === 'none');
            hidden.slice(0, 5).forEach(el => { el.style.display = ''; });
            const stillHidden = hidden.length - Math.min(5, hidden.length);
            if (stillHidden === 0) {
                loadMoreBtn.style.display = 'none';
            } else {
                loadMoreBtn.dataset.remaining = stillHidden;
                loadMoreBtn.textContent = message('loadMoreReplies', 'Load :count more').replace(':count', stillHidden);
            }
        }

        // Click "Collapse replies"
        const collapseBtn = e.target.closest('.replies-collapse-btn');
        if (collapseBtn) {
            const cid = collapseBtn.dataset.commentId;
            const container = document.getElementById('replies-' + cid);
            if (container) container.style.display = 'none';
            const toggleBtn = document.querySelector(`.replies-toggle[data-comment-id="${cid}"]`);
            if (toggleBtn) {
                toggleBtn.classList.remove('expanded');
                updateRepliesToggleLabel(toggleBtn, false);
            }
        }

        // Click "share" button on a post
        const shareBtn = e.target.closest('.action-btn.share');
        if (shareBtn) {
            const pid = shareBtn.dataset.postId;
            const url = window.location.origin + '/posts#post-' + pid;
            navigator.clipboard.writeText(url).then(() => {
                window.toast?.success(message('linkCopied', 'Link copied to clipboard!'));
            }).catch(() => {
                const inp = document.createElement('input');
                inp.value = url;
                document.body.appendChild(inp);
                inp.select();
                document.execCommand('copy');
                document.body.removeChild(inp);
                window.toast?.success(message('linkCopied', 'Link copied to clipboard!'));
            });
        }

        // Click "edit" button on a comment
        const editBtn = e.target.closest('.edit-comment-btn');
        if (editBtn) {
            const cid = editBtn.dataset.commentId;
            const textEl = document.getElementById('comment-text-' + cid);
            const formEl = document.getElementById('edit-comment-form-' + cid);
            if (textEl && formEl) { textEl.style.display = 'none'; formEl.style.display = 'block'; }
        }

        // Click "cancel" edit on a comment
        const cancelEdit = e.target.closest('.cancel-edit-comment');
        if (cancelEdit) {
            const cid = cancelEdit.dataset.commentId;
            const textEl = document.getElementById('comment-text-' + cid);
            const formEl = document.getElementById('edit-comment-form-' + cid);
            if (textEl && formEl) { textEl.style.display = 'block'; formEl.style.display = 'none'; }
        }
    });

    // Delegated: edit comment form submit + post edit/delete + comment delete fallback
    document.addEventListener('submit', async function(e) {

        // --- Comment edit ---
        const editForm = e.target.closest('.comment-edit-form');
        if (editForm) {
            e.preventDefault();
            const cid = editForm.id.replace('edit-comment-form-', '');
            try {
                const res = await fetch(editForm.action, {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    body: new FormData(editForm)
                });
                const data = await res.json();
                if (data.success) {
                    window.toast?.success(message('commentUpdated', 'Comment updated'));
                    const textEl = document.getElementById('comment-text-' + cid);
                    if (textEl) {
                        // Preserve quote block, only update the <p> text
                        const pEl = textEl.querySelector('p');
                        if (pEl) {
                            pEl.textContent = data.comment.content;
                        } else {
                            const newP = document.createElement('p');
                            newP.textContent = data.comment.content;
                            textEl.appendChild(newP);
                        }
                        textEl.style.display = 'block';
                    }
                    // Show "edited" badge
                    const editedBadge = document.getElementById('comment-edited-' + cid);
                    if (editedBadge) editedBadge.style.removeProperty('display');
                    // Update any quote blocks from other comments that cite this comment
                    document.querySelectorAll('.comment-quote[data-quoted-id="' + cid + '"]').forEach(qEl => {
                        const qText = qEl.querySelector('.comment-quote-text');
                        if (qText) qText.textContent = data.comment.content.substring(0, 100);
                    });
                    editForm.style.display = 'none';
                } else {
                    window.toast?.error(data.message || 'Error');
                }
            } catch { window.toast?.error(toastMessage('comment_update_error', 'Failed to update comment')); }
            return;
        }

        // --- Post edit ---
        const editPostForm = e.target.closest('.edit-form[id^="edit-post-form-"]');
        if (editPostForm) {
            e.preventDefault();
            const postId = editPostForm.id.replace('edit-post-form-', '');
            const postBodyEl = document.getElementById('post-body-' + postId);
            const submitBtn = editPostForm.querySelector('button[type="submit"]');
            if (submitBtn) submitBtn.disabled = true;
            try {
                const res = await fetch(editPostForm.action, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                    body: new FormData(editPostForm)
                });
                const data = await res.json();
                if (data.success) {
                    window.toast?.success(toastMessage('post_updated', 'Post updated'));
                    if (postBodyEl) {
                        const p = postBodyEl.querySelector('p');
                        if (p) p.textContent = data.post.content;
                        postBodyEl.style.display = 'block';
                    }
                    editPostForm.style.display = 'none';
                    const editedBadge = document.getElementById('post-edited-' + postId);
                    if (editedBadge) editedBadge.style.removeProperty('display');
                } else {
                    window.toast?.error(data.message || toastMessage('post_update_error', 'Failed to update post'));
                }
            } catch (err) {
                window.toast?.error(toastMessage('post_update_error', 'Failed to update post'));
            } finally {
                if (submitBtn) submitBtn.disabled = false;
            }
            return;
        }

        // --- Post delete ---
        const deletePostForm = e.target.closest('.delete-post-form');
        if (deletePostForm) {
            e.preventDefault();
            const confirmed = await window.confirmAsync(
                (window.postsConfirmMessages?.deletePost) || 'Are you sure you want to delete this post?'
            );
            if (!confirmed) return;
            const postEl = deletePostForm.closest('.post');
            try {
                const res = await fetch(deletePostForm.action, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                    body: new FormData(deletePostForm)
                });
                const data = await res.json();
                if (data.success) {
                    window.toast?.success(toastMessage('post_deleted', 'Post deleted'));
                    postEl?.remove();
                } else {
                    window.toast?.error(data.message || toastMessage('post_delete_error', 'Failed to delete post'));
                }
            } catch (err) {
                window.toast?.error(toastMessage('post_delete_error', 'Failed to delete post'));
            }
            return;
        }

        // --- Comment / reply delete (posts.js handles these; blade catches any missed by posts.js) ---
        const inlineDeleteForm = e.target.closest('.inline-delete');
        if (inlineDeleteForm && !e.defaultPrevented) {
            e.preventDefault();
            const confirmed = await window.confirmAsync(
                (window.postsConfirmMessages?.deleteComment) || 'Are you sure you want to delete this comment?'
            );
            if (!confirmed) return;
            const commentEl = inlineDeleteForm.closest('.comment-item, .comment');
            const postId = commentEl?.closest('.post')?.dataset.postId;
            try {
                const res = await fetch(inlineDeleteForm.action, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                    body: new FormData(inlineDeleteForm)
                });
                const data = await res.json();
                if (data.success) {
                    window.toast?.success(toastMessage('comment_deleted', 'Comment deleted'));
                    commentEl?.remove();
                    if (postId) {
                        const toggle = document.querySelector(`.comment-toggle[data-post-id="${postId}"]`);
                        if (toggle) {
                            const span = toggle.querySelector('span');
                            if (span) span.textContent = Math.max(0, parseInt(span.textContent || '0') - 1);
                        }
                    }
                } else {
                    window.toast?.error(data.message || toastMessage('comment_delete_error', 'Failed to delete comment'));
                }
            } catch (err) {
                window.toast?.error(toastMessage('comment_delete_error', 'Failed to delete comment'));
            }
            return;
        }
    });

    // Override form submit for comment/reply mode
    composerForm.addEventListener('submit', async function(e) {
        const mode = composerMode.value;
        if (mode === 'comment' || mode === 'reply') {
            e.preventDefault();
            let content = composerText.value.trim();
            if (!content) return;

            // Prepend @username for replies
            if (mode === 'reply' && composerReplyToUser) {
                const mention = '@' + composerReplyToUser;
                if (!content.startsWith(mention)) {
                    content = mention + ' ' + content;
                }
            }

            const postId = composerPostId.value;
            const parentId = composerParentId.value;
            const fd = new FormData();
            fd.append('content', content);
            fd.append('_token', csrfToken);
            if (parentId) fd.append('parent_id', parentId);
            const replyToId = composerReplyToIdInput.value;
            if (replyToId) fd.append('reply_to_id', replyToId);

            try {
                const res = await fetch('/posts/' + postId + '/comment', {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    body: fd
                });
                const data = await res.json();
                if (data.success && data.comment) {
                    window.toast?.success(toastMessage('comment_added', 'Comment added'));
                    composerText.value = '';
                    composerText.dispatchEvent(new Event('input'));

                    // Insert comment dynamically
                    const c = data.comment;
                    const esc = s => {
                        const d = document.createElement('div');
                        d.textContent = s;
                        return d.innerHTML;
                    };
                    const avatarSrc = c.user_avatar ? '/storage/' + esc(c.user_avatar) : '/storage/default-avatar/default-avatar.avif';
                    const rootId = c.parent_id || c.id;
                    // Highlight leading @mention in content
                    let displayContent = esc(c.content);
                    const mentionMatch = displayContent.match(/^(@\w+\s)/);
                    if (mentionMatch) {
                        displayContent = '<span class="comment-mention">' + mentionMatch[1] + '</span>' + displayContent.slice(mentionMatch[1].length);
                    }

                    const commentHtml = '<div class="comment-item' + (c.is_reply ? ' is-reply' : '') + '" id="comment-' + c.id + '">' +
                        '<img src="' + avatarSrc + '" class="comment-avatar">' +
                        '<div class="comment-content">' +
                        '<div class="comment-header">' +
                        '<a href="/profile/' + esc(c.user_username) + '" class="comment-author">' + esc(c.user_name) + '</a>' +
                        '<span class="comment-username">@' + esc(c.user_username) + '</span>' +
                        '<span class="comment-time">' + esc(c.time_ago) + '</span>' +
                        '</div>' +
                        '<div class="comment-text" id="comment-text-' + c.id + '"><p>' + displayContent + '</p></div>' +
                        '<div class="comment-actions">' +
                        '<button class="comment-btn like" data-comment-id="' + c.id + '"><svg viewBox="0 0 24 24" width="14" height="14" fill="currentColor"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg> 0</button>' +
                        '<button class="comment-btn reply-btn" data-comment-id="' + c.id + '" data-post-id="' + postId + '" data-reply-to-id="' + c.id + '" data-reply-to-user="' + esc(c.user_username) + '">' + message('reply', 'Reply') + '</button>' +
                        (c.can_delete ? '<form action="/posts/comments/' + c.id + '" method="POST" class="inline-delete"><input type="hidden" name="_method" value="DELETE"><input type="hidden" name="_token" value="' + csrfToken + '"><button class="comment-btn delete">' + message('delete', 'Delete') + '</button></form>' : '') +
                        '</div>' +
                        '</div>' +
                        '</div>';

                    // Append to comments list
                    const commentsList = document.querySelector('.post[data-post-id="' + postId + '] .comments-list');
                    if (commentsList) {
                        const emptyState = commentsList.querySelector('.comments-empty');
                        if (emptyState) emptyState.remove();
                        commentsList.insertAdjacentHTML('beforeend', commentHtml);
                    }

                    // Update comment count
                    const countSpan = document.querySelector('.post[data-post-id="' + postId + '"] .comment-toggle span');
                    if (countSpan) {
                        countSpan.textContent = parseInt(countSpan.textContent || '0') + 1;
                    }

                    setComposerMode('post');
                } else {
                    window.toast?.error(data.message || toastMessage('comment_add_error', 'Failed to add comment'));
                }
            } catch (err) {
                window.toast?.error(toastMessage('comment_add_error', 'Failed to add comment'));
            }
        }
    });
});