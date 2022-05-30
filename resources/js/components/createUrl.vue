<template>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header text-center">
                Paste the URL to be shortened!
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-sm-10">

                        <input @focusin="resetErrors" v-model="form.url" type="text" class="form-control"
                            placeholder="Enter the link here!">

                        <div class="text-sm text-danger" if="hasValidationError">
                            <p v-for="validation in validations" :key="validations">
                                <small>{{ validation }}</small>
                            </p>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <button @click="submit" type="button" class="btn btn-primary">Shorten Url</button>
                    </div>
                </div>

                <div class="text-sm text-success" if="hasResult">
                    <p>{{ results.message }} <a target="_blank" :href='results.url'>{{ results.url }}</a></p>
                </div>

                <div class="text-sm text-danger" if="hasError">
                    <p v-for="error in errors" :key="errors">
                        {{ error }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
import axios from 'axios'
import { reactive, ref } from 'vue'

export default {
    setup() {
        const validations = ref([]);
        const errors = ref([]);
        const results = ref([]);

        const form = reactive({
            url: ''
        })

        const submit = async () => {
            resetResult();
            try {
                const res = await axios.post('api/generate-short-url', form);
                results.value = res.data
                resetForm();
            } catch (e) {
                if (e.response.status === 422) {
                    validations.value = e.response.data.errors.url;
                } else {
                    errors.value = e.response.data.errors.message
                }
            }
        }

        const hasError = () => {
            return !!errors.length
        }

        const hasValidationError = () => {
            return !!validations.length
        }

        const hasResult = () => {
            return !!results.length
        }

        const resetErrors = () => {
            errors.value = [];
            validations.value = [];
        }

        const resetForm = () => {
            form.url = '';
        }

        const resetResult = () => {
            results.value = [];
        }

        return {
            form,
            submit,
            errors,
            validations,
            hasError,
            hasValidationError,
            hasResult,
            resetErrors,
            resetForm,
            results
        }
    }
}
</script>