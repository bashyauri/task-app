// import { useToast } from "vue-toast-notification";
// import "vue-toast-notification/dist/theme-sugar.css";

// const $toast = useToast();
// let instance = $toast.success("You did it!");

// // Force dismiss specific toast
// instance.dismiss();

// // Dismiss all opened toast immediately
// $toast.clear();

// import {useToast} from 'vue-toast-notification';
// import 'vue-toast-notification/dist/theme-sugar.css';

// const $toast = useToast();
// let instance = $toast.success('You did it!');
import { useToast } from "vue-toast-notification";

const toast = useToast();

export function showError(message) {
    toast.error(message, {
        position: "bottom-right",
        duration: 4000,
        dismissible: true,
    });
}

export function successMsg(message) {
    toast.success(message, {
        position: "bottom-right",
        duration: 4000,
        dismissible: true,
    });
}
