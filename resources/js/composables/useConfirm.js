import { ref } from 'vue';

const isOpen = ref(false);
const confirmTitle = ref('');
const confirmMessage = ref('');
let resolvePromise = null;

export function useConfirm() {
  const confirm = (options) => {
    isOpen.value = true;
    confirmTitle.value = options.title;
    confirmMessage.value = options.message;
    
    return new Promise((resolve) => {
      resolvePromise = resolve;
      
      if (options.onConfirm) {
        resolve(options.onConfirm());
      }
    });
  };

  const handleConfirm = () => {
    isOpen.value = false;
    if (resolvePromise) {
      resolvePromise(true);
      resolvePromise = null;
    }
  };

  const handleCancel = () => {
    isOpen.value = false;
    if (resolvePromise) {
      resolvePromise(false);
      resolvePromise = null;
    }
  };

  return {
    isOpen,
    confirmTitle,
    confirmMessage,
    confirm,
    handleConfirm,
    handleCancel
  };
}