import { clsx, type ClassValue } from 'clsx';
import { twMerge } from 'tailwind-merge';
import { toast } from 'vue-sonner';

export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs));
}

export function copyCode(value: string, message: string = 'Código copiado', description: string = 'El código se ha copiado en el portapapeles') {
    navigator.clipboard.writeText(value).then(() => toast(message, { description }));
}
