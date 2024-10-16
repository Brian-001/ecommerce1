/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  safelist : [
    'text-gray-600',
    'bg-gray-100',
    'text-green-600',
    'bg-green-100',
    'text-yellow-600',
    'bg-yellow-100',
    'text-blue-600',
    'bg-blue-100',
    'text-red-600',
    'bg-red-100',
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}

