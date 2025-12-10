import type { Config } from 'tailwindcss';

export default {
  content: ['./src/**/*.{js,jsx,ts,tsx}'],
  theme: {
    extend: {},
  },
  plugins: [require('daisyui')],
  daisyui: {
    themes: ['light', 'dark', 'cupcake', 'corporate'],
    darkTheme: 'dark',
    base: true,
    styled: true,
    utils: true,
    logs: false,
  },
} satisfies Config;
