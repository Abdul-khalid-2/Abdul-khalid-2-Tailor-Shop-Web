// RetailPro Dashboard JavaScript

class Dashboard {
    constructor() {
        this.init();
    }

    init() {
        this.setupSidebar();
        this.setupNotifications();
        this.setupFullscreen();
        this.setupBranchSelector();
        this.setupEventListeners();
        this.updateDateTime();
        this.setupToastr();
    }

    setupSidebar() {
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarToggleMobile = document.getElementById('sidebarToggleMobile');

        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', () => this.toggleSidebar());
        }

        if (sidebarToggleMobile) {
            sidebarToggleMobile.addEventListener('click', () => this.toggleMobileSidebar());
        }

        // Load sidebar state from localStorage
        const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
        if (isCollapsed) {
            document.body.classList.add('sidebar-collapsed');
        }
    }

    toggleSidebar() {
        document.body.classList.toggle('sidebar-collapsed');
        localStorage.setItem('sidebarCollapsed', document.body.classList.contains('sidebar-collapsed'));
    }

    toggleMobileSidebar() {
        document.body.classList.toggle('sidebar-collapsed');
    }

    setupNotifications() {
        const markAllReadBtn = document.getElementById('markAllRead');
        const notificationCount = document.getElementById('notificationCount');

        if (markAllReadBtn) {
            markAllReadBtn.addEventListener('click', (e) => {
                e.preventDefault();
                if (notificationCount) {
                    notificationCount.style.display = 'none';
                }
                this.showToast('All notifications marked as read', 'success');
            });
        }

        // Simulate real-time notifications
        this.simulateNotifications();
    }

    simulateNotifications() {
        setInterval(() => {
            const count = Math.floor(Math.random() * 3);
            if (count > 0) {
                this.showToast(`${count} new notification${count > 1 ? 's' : ''} received`, 'info');
            }
        }, 30000); // Every 30 seconds
    }

    setupFullscreen() {
        const fullscreenToggle = document.getElementById('fullscreenToggle');

        if (fullscreenToggle) {
            fullscreenToggle.addEventListener('click', () => {
                if (!document.fullscreenElement) {
                    document.documentElement.requestFullscreen();
                    fullscreenToggle.innerHTML = '<i class="fas fa-compress fa-lg"></i>';
                } else {
                    if (document.exitFullscreen) {
                        document.exitFullscreen();
                        fullscreenToggle.innerHTML = '<i class="fas fa-expand fa-lg"></i>';
                    }
                }
            });
        }
    }

    setupBranchSelector() {
        const branchSelector = document.getElementById('branchSelector');

        if (branchSelector) {
            branchSelector.addEventListener('change', (e) => {
                const branchId = e.target.value;
                this.switchBranch(branchId);
            });

            // Load current branch from localStorage
            const savedBranch = localStorage.getItem('currentBranch');
            if (savedBranch) {
                branchSelector.value = savedBranch;
            }
        }
    }

    switchBranch(branchId) {
        // In a real app, make an AJAX call here
        localStorage.setItem('currentBranch', branchId);

        this.showToast(`Switched to branch ${branchId}`, 'info');

        // Simulate data refresh
        setTimeout(() => {
            this.refreshDashboardData();
        }, 500);
    }

    refreshDashboardData() {
        // Simulate API call
        const event = new CustomEvent('dashboard:refresh', {
            detail: { timestamp: new Date().toISOString() }
        });
        window.dispatchEvent(event);
    }

    setupEventListeners() {
        // Refresh dashboard data on custom event
        window.addEventListener('dashboard:refresh', (e) => {
            console.log('Dashboard refreshed at:', e.detail.timestamp);
            this.showToast('Dashboard data refreshed', 'success');
        });

        // Handle window resize
        window.addEventListener('resize', this.handleResize.bind(this));

        // Handle page visibility change
        document.addEventListener('visibilitychange', () => {
            if (!document.hidden) {
                this.refreshDashboardData();
            }
        });
    }

    handleResize() {
        if (window.innerWidth < 992) {
            document.body.classList.add('sidebar-collapsed');
        }
    }

    updateDateTime() {
        const updateTime = () => {
            const now = new Date();
            const serverTimeEl = document.getElementById('serverTime');
            if (serverTimeEl) {
                serverTimeEl.textContent = now.toLocaleString('en-US', {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit'
                });
            }
        };

        updateTime();
        setInterval(updateTime, 1000);
    }

    setupToastr() {
        // Toastr is already loaded, just configure it
        if (typeof toastr !== 'undefined') {
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "3000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
        }
    }

    showToast(message, type = 'info') {
        if (typeof toastr !== 'undefined') {
            switch (type) {
                case 'success':
                    toastr.success(message);
                    break;
                case 'warning':
                    toastr.warning(message);
                    break;
                case 'error':
                    toastr.error(message);
                    break;
                default:
                    toastr.info(message);
            }
        } else {
            console.log(`${type.toUpperCase()}: ${message}`);
        }
    }

    // Chart Utilities
    static createLineChart(canvasId, data, options = {}) {
        const ctx = document.getElementById(canvasId);
        if (!ctx) return null;

        const defaultOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            }
        };

        return new Chart(ctx.getContext('2d'), {
            type: 'line',
            data: data,
            options: { ...defaultOptions, ...options }
        });
    }

    static createBarChart(canvasId, data, options = {}) {
        const ctx = document.getElementById(canvasId);
        if (!ctx) return null;

        const defaultOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            }
        };

        return new Chart(ctx.getContext('2d'), {
            type: 'bar',
            data: data,
            options: { ...defaultOptions, ...options }
        });
    }

    static createPieChart(canvasId, data, options = {}) {
        const ctx = document.getElementById(canvasId);
        if (!ctx) return null;

        const defaultOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        };

        return new Chart(ctx.getContext('2d'), {
            type: 'pie',
            data: data,
            options: { ...defaultOptions, ...options }
        });
    }

    // Export data
    exportData(type = 'pdf') {
        switch (type) {
            case 'pdf':
                this.exportToPDF();
                break;
            case 'excel':
                this.exportToExcel();
                break;
            case 'csv':
                this.exportToCSV();
                break;
        }
    }

    exportToPDF() {
        // Implement PDF export using jsPDF
        this.showToast('PDF export would be implemented with jsPDF', 'info');
    }

    exportToExcel() {
        // Implement Excel export
        this.showToast('Excel export would be implemented with SheetJS', 'info');
    }

    exportToCSV() {
        // Implement CSV export
        this.showToast('CSV export would be implemented', 'info');
    }

    // Data fetching utilities
    static async fetchData(endpoint, options = {}) {
        const defaultOptions = {
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        };

        try {
            const response = await fetch(endpoint, { ...defaultOptions, ...options });
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return await response.json();
        } catch (error) {
            console.error('Error fetching data:', error);
            throw error;
        }
    }

    // Local storage utilities
    static setItem(key, value) {
        try {
            localStorage.setItem(key, JSON.stringify(value));
            return true;
        } catch (error) {
            console.error('Error saving to localStorage:', error);
            return false;
        }
    }

    static getItem(key) {
        try {
            const item = localStorage.getItem(key);
            return item ? JSON.parse(item) : null;
        } catch (error) {
            console.error('Error reading from localStorage:', error);
            return null;
        }
    }

    static removeItem(key) {
        try {
            localStorage.removeItem(key);
            return true;
        } catch (error) {
            console.error('Error removing from localStorage:', error);
            return false;
        }
    }
}

// Initialize dashboard when DOM is loaded
document.addEventListener('DOMContentLoaded', function () {
    window.dashboard = new Dashboard();

    // Hide preloader
    setTimeout(() => {
        const preloader = document.getElementById('preloader');
        if (preloader) {
            preloader.style.transition = 'opacity 0.5s ease';
            preloader.style.opacity = '0';
            setTimeout(() => {
                preloader.style.display = 'none';
            }, 500);
        }
    }, 500);

    // Setup keyboard shortcuts
    document.addEventListener('keydown', function (e) {
        // Ctrl + S to save
        if (e.ctrlKey && e.key === 's') {
            e.preventDefault();
            window.dashboard.showToast('Save functionality triggered', 'info');
        }

        // Ctrl + K to search
        if (e.ctrlKey && e.key === 'k') {
            e.preventDefault();
            window.dashboard.showToast('Search triggered', 'info');
        }

        // Escape to close modals
        if (e.key === 'Escape') {
            const openModals = document.querySelectorAll('.modal.show');
            if (openModals.length > 0) {
                openModals.forEach(modal => {
                    const modalInstance = bootstrap.Modal.getInstance(modal);
                    if (modalInstance) {
                        modalInstance.hide();
                    }
                });
            }
        }
    });
});

// Make Dashboard class available globally
window.Dashboard = Dashboard;