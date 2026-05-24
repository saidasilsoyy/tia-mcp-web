export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './app/**/*.php',
        './routes/**/*.php',
    ],
    theme: {
        extend: {
            colors: {
                ink: '#111827',
                factory: '#f5f4ee',
                steel: '#334155',
                copper: '#b45309',
                signal: '#0f766e',
            },
            borderRadius: {
                panel: '0.5rem',
            },
        },
    },
};
