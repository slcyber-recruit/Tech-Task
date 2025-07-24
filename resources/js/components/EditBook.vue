<template>
    <div>
        <Header />
        <div class="w-1/5 mx-auto text-left">
            <form @submit.prevent="submit">
                <div class="pt-10">
                    <h2 class="text-center text-3xl pb-10">Edit Book</h2>
                    <div class="pb-10">
                        <label class="w-20 inline-block">Title: </label>
                        <input type="text" v-model="form.title" placeholder="Title"
                               class="rounded-md border-gray-400 border p-2 w-96">
                    </div>
                    <div class="pb-10">
                        <label class="w-20 inline-block">Author: </label>
                        <input type="text" v-model="form.author" placeholder="Author"
                               class="rounded-md border-gray-400 border p-2 w-96">
                    </div>
                    <div class="pb-10">
                        <label class="w-20 inline-block">Rating: </label>
                        <input type="number" v-model.number="form.rating" placeholder="5"
                               class="rounded-md border-gray-400 border p-2 w-96">
                    </div>
                </div>
                <div class="text-center">
                    <button class="text-white bg-orange py-2 px-4 rounded" type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import Header from './Header.vue'

export default {
    name: 'EditBook',
    props: {
        bookId: {
            type: Number,
            required: true
        },
        title: {
            type: String,
            required: true
        },
        author: {
            type: String,
            required: true
        },
        rating: {
            type: [Number, String],
            required: true
        }
    },
    data() {
        return {
            form: {
                title: this.title,
                author: this.author,
                rating: this.rating
            }
        };
    },
    methods: {
        async submit() {
            try {
                const response = await axios.put(`/api/books/${this.bookId}`, this.form);
                alert('Book updated successfully!');
                window.location.href = '/';
            } catch (error) {
                alert('Error updating the book.');
                console.error(error.response?.data || error.message);
            }
        }
    }
}
</script>
