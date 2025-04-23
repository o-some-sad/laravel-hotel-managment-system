<script setup>
import { useForm } from '@inertiajs/vue3'
import Input from '@/components/ui/input'

const form = useForm({
    name: '',
    email: '',
    password: '',
    national_id: ''
})
</script>