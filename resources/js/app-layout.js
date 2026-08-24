import Alpine from 'alpinejs';

Alpine.data('appLayout', () => ({
    sidebarOpen: localStorage.getItem('sidebarOpen') !== null 
        ? localStorage.getItem('sidebarOpen') === 'true' 
        : window.innerWidth >= 1024,
    darkMode: localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
    
    init() {
        this.$watch('sidebarOpen', value => {
            localStorage.setItem('sidebarOpen', value);
            if (value) {
                document.documentElement.classList.remove('sidebar-collapsed');
            } else {
                document.documentElement.classList.add('sidebar-collapsed');
            }
        });
        
        // Sync document class initially
        if (this.sidebarOpen) {
            document.documentElement.classList.remove('sidebar-collapsed');
        } else {
            document.documentElement.classList.add('sidebar-collapsed');
        }
    },
    
    toggleTheme() {
        this.darkMode = !this.darkMode;
        if (this.darkMode) {
            document.documentElement.classList.add('dark');
            localStorage.setItem('theme', 'dark');
        } else {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('theme', 'light');
        }
        window.dispatchEvent(new CustomEvent('theme-changed', { detail: { darkMode: this.darkMode } }));
    }
}));
