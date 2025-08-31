import { clsx, type ClassValue } from 'clsx';
import { twMerge } from 'tailwind-merge';
import { toast } from 'vue-sonner';

export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs));
}

export function copyCode(
    value: string,
    message: string = 'Código copiado',
    description: string = 'El código se ha copiado en el portapapeles',
) {
    navigator.clipboard
        .writeText(value)
        .then(() => toast(message, { description }));
}

export function middleEllipsis(str: string, length1 = 12, length2 = 10) {
    const parts = str.split('.');

    const ext = parts.pop()!;
    const text = parts.join('.');

    if (text.length <= length1 + length2) return str;

    return `${text.slice(0, length1)} ... ${text.slice(-length2 + ext.length)}.${ext}`;
}
