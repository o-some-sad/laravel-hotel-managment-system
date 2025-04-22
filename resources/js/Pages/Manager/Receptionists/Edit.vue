<script setup>
import { useForm } from '@inertiajs/vue3'
import { Input } from '@/components/ui/input'

const props = defineProps({
  receptionist: Object
})

const form = useForm({ 
  // ... 
})
</script>