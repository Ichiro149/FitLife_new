/* Šis skripts nodrošina "goalsindex" publiskās saskarnes interaktivitāti. */

document.addEventListener("DOMContentLoaded", function () {
    const toggle = document.getElementById('mobile-toggle');
    const sidebar = document.getElementById('sidebar');
    const createBackdrop = document.getElementById('createGoalBackdrop');
    const logBackdrop = document.getElementById('logProgressBackdrop');
    const logForm = document.getElementById('logProgressForm');
    const logSubtitle = document.getElementById('logProgressSubtitle');
    const logGoalId = document.getElementById('logGoalId');
    const logGoalType = document.getElementById('logGoalType');
    const logGoalCurrent = document.getElementById('logGoalCurrent');
    const logValueInput = document.getElementById('log_value');
    const logSubmit = document.getElementById('logProgressSubmit');
    const logCurrentTotal = document.getElementById('logCurrentTotal');
    const logProjectedTotal = document.getElementById('logProjectedTotal');
    const createTargetInput = document.getElementById('gm_target_value');

    function formatProgressNumber(value) {
        if (!Number.isFinite(value)) {
            return '0';
        }

        const hasFraction = Math.abs(value % 1) > 0.001;

        return value.toLocaleString(undefined, {
            minimumFractionDigits: hasFraction ? 2 : 0,
            maximumFractionDigits: hasFraction ? 2 : 0,
        });
    }

    function updateLogTotals() {
        const currentValue = parseFloat(logGoalCurrent?.value || '0') || 0;
        const incrementValue = parseFloat(logValueInput?.value || '0') || 0;
        const projectedValue = currentValue + incrementValue;

        if (logCurrentTotal) {
            logCurrentTotal.textContent = formatProgressNumber(currentValue);
        }

        if (logProjectedTotal) {
            logProjectedTotal.textContent = formatProgressNumber(projectedValue);
        }
    }

    function syncBodyScroll() {
        const hasOpenModal = document.querySelector('.gm-backdrop.gm-open');
        document.body.style.overflow = hasOpenModal ? 'hidden' : '';
    }

    function closeSidebar() {
        if (sidebar && sidebar.classList.contains('active')) {
            sidebar.classList.remove('active');
            if (toggle) {
                toggle.setAttribute('aria-expanded', 'false');
            }
        }
    }

    function closeModal(backdrop) {
        if (!backdrop) {
            return;
        }

        backdrop.classList.remove('gm-open');
        backdrop.setAttribute('aria-hidden', 'true');
        syncBodyScroll();
    }

    function openModal(backdrop, focusTarget) {
        if (!backdrop) {
            return;
        }

        document.querySelectorAll('.gm-backdrop.gm-open').forEach((openBackdrop) => {
            if (openBackdrop !== backdrop) {
                closeModal(openBackdrop);
            }
        });

        backdrop.classList.add('gm-open');
        backdrop.setAttribute('aria-hidden', 'false');
        syncBodyScroll();

        if (focusTarget) {
            window.setTimeout(() => focusTarget.focus(), 160);
        }
    }

    if (toggle && sidebar) {
        toggle.addEventListener('click', () => {
            const open = sidebar.classList.toggle('active');
            toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        });

        document.addEventListener('click', (event) => {
            if (sidebar.classList.contains('active') && !sidebar.contains(event.target) && !toggle.contains(event.target)) {
                closeSidebar();
            }
        });
    }

    document.querySelectorAll('.gm-backdrop').forEach((backdrop) => {
        backdrop.addEventListener('click', (event) => {
            if (event.target === backdrop) {
                closeModal(backdrop);
            }
        });
    });

    document.addEventListener('keydown', (event) => {
        if (event.key !== 'Escape') {
            return;
        }

        const openBackdrop = document.querySelector('.gm-backdrop.gm-open');
        if (openBackdrop) {
            closeModal(openBackdrop);
            return;
        }

        closeSidebar();
    });

    const openCreateBtn = document.getElementById('openCreateGoal');
    const closeCreateBtn = document.getElementById('closeCreateGoal');
    if (openCreateBtn && createBackdrop) {
        openCreateBtn.addEventListener('click', () => openModal(createBackdrop, createTargetInput));
    }

    if (closeCreateBtn && createBackdrop) {
        closeCreateBtn.addEventListener('click', () => closeModal(createBackdrop));
    }

    const closeLogBtn = document.getElementById('closeLogProgress');
    if (closeLogBtn && logBackdrop) {
        closeLogBtn.addEventListener('click', () => closeModal(logBackdrop));
    }

    document.querySelectorAll('.open-log-modal').forEach((button) => {
        button.addEventListener('click', () => {
            if (!logForm || !logBackdrop) {
                return;
            }

            logForm.action = button.dataset.logUrl || '';

            if (logSubtitle) {
                logSubtitle.textContent = button.dataset.goalSubtitle || '';
            }

            if (logGoalId) {
                logGoalId.value = button.dataset.goalId || '';
            }

            if (logGoalType) {
                logGoalType.value = button.dataset.goalType || '';
            }

            if (logGoalCurrent) {
                logGoalCurrent.value = button.dataset.goalCurrent || '0';
            }

            if (logValueInput) {
                logValueInput.value = '';
            }

            if (logSubmit) {
                logSubmit.disabled = false;
            }

            updateLogTotals();

            openModal(logBackdrop, logValueInput);
        });
    });

    if (logValueInput) {
        logValueInput.addEventListener('input', updateLogTotals);
    }

    updateLogTotals();

    syncBodyScroll();
});
