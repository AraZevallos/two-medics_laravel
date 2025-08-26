<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Form, Head } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

defineProps<{
    isValidEmail?: boolean;
}>();
</script>

<template>
    <AuthBase title="Inicia sesión en tu cuenta" description="Ingresa tu correo electrónico">
        <Head title="Iniciar sesión" />

        <Form
            method="post"
            :action="route(isValidEmail ? 'login' : 'valid-email')"
            :reset-on-success="['password']"
            v-slot="{ errors, processing }"
            class="flex flex-col gap-6"
        >
            <div class="grid gap-6">
                <div class="grid gap-2">
                    <Label for="email">Correo electrónico</Label>
                    <Input
                        :readonly="isValidEmail"
                        :tabindex="1"
                        autocomplete="email"
                        autofocus
                        id="email"
                        name="email"
                        placeholder="email@example.com"
                        required
                        type="email"
                    />
                    <InputError :message="errors.email" />
                </div>

                <div v-if="isValidEmail" class="grid gap-2">
                    <Label for="password">Contraseña</Label>
                    <Input
                        id="password"
                        type="password"
                        name="password"
                        required
                        :tabindex="2"
                        autocomplete="current-password"
                        placeholder="Password"
                    />
                    <InputError :message="errors.password" />
                </div>

                <Button type="submit" class="mt-4 w-full" :tabindex="4" :disabled="processing">
                    <LoaderCircle v-if="processing" class="h-4 w-4 animate-spin" />
                    {{ isValidEmail ? 'Iniciar sesión' : 'Enviar código de acceso' }}
                </Button>
            </div>
        </Form>
    </AuthBase>
</template>
