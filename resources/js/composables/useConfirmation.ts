import { ref } from 'vue';

const isVisible = ref(false);
const message = ref('');
const isError = ref(false);
const resolveFn = ref<(() => void) | null>(null);

export function useConfirmation() {
    function show(newMessage: string, newStatus = false) {
        message.value = newMessage;
        isError.value = newStatus;

        isVisible.value = true;

        return new Promise<void>((resolve) => {
            resolveFn.value = resolve;
        });
    }

    function close() {
        isVisible.value = false;

        if (resolveFn.value) {
            resolveFn.value();
            resolveFn.value = null;
        }
    }

    return {
        isVisible,
        isError,
        message,
        show,
        close,
    };
}
