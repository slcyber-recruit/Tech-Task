<template>
  <div>
    <Header />
    <main class="container">
      <div class="row mb-3 search-bar">
        <div class="col-md-4 offset-md-8 float_right">
          <form @submit.prevent="searchBooks" class="d-flex">
            <input
              type="text"
              class="form-control me-2"
              placeholder="Search by book title..."
              v-model="searchQuery"
            >
          </form>
        </div>
      </div>

      <div class="row table-responsive">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Title</th>
              <th>Author</th>
              <th>Rating</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-if="loading">
              <td colspan="4" class="text-center">Loading books...</td>
            </tr>
            <tr v-else-if="books.length === 0">
              <td colspan="4" class="text-center">No books found.</td>
            </tr>
            <tr v-for="book in books" :key="book.id">
              <td>{{ book.title }}</td>
              <td>{{ book.author }}</td>
              <td>{{ book.rating }}</td>
              <td>
                <a :href="`/books/${book.id}/edit`" class="action-link">Edit</a>
                <button @click="deleteBook(book.id)" class="action-link">Delete</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </main>
  </div>
</template>

<script>
import Header from './Header.vue'
export default {
  name: 'BookListing',
  data() {
    return {
      books: [],
      searchQuery: '',
      loading: true
    }
  },
  mounted() {
    this.fetchBooks()
  },
  methods: {
    async fetchBooks() {
      try {
        this.loading = true
        const response = await axios.get('/api/books', {
          params: {
            search: this.searchQuery
          }
        })
        this.books = response.data
      } catch (error) {
        console.error('Error fetching books:', error)
      } finally {
        this.loading = false
      }
    },
    searchBooks() {
      this.fetchBooks()
    },
    async deleteBook(id) {
      if (confirm('Are you sure?')) {
        try {
          await axios.delete(`/api/books/${id}`)
          this.books = this.books.filter(book => book.id !== id)
        } catch (error) {
          console.error('Error deleting book:', error)
        }
      }
    }
  }
}
</script>

<style scoped>
/* General body styling */
body {
    background-color: #f8f9fa;
}

.float_right{
    float: right;
}

/* Container styling */
.container {
    padding-top: 2rem;
    max-width: 75%; /* Sets the maximum width to 75% of its parent */
    margin-left: auto; /* Centers the block-level element horizontally */
    margin-right: auto; /* Centers the block-level element horizontally */
}

/* Table responsiveness and general table styling */
.table-responsive {
    margin-top: 1rem;
}

.table th, .table td {
    vertical-align: middle;
    border-color: red;
}
.table th, .table td {
    vertical-align: middle;
    text-align: left;
}
.table tbody tr:hover {
    background-color: #f1f1f1;
}
.table thead {
    background-color: #1f2936;
    color: white;
    text-align: left;
    border-color: #f1f1f1;
}
.table tbody {
    background-color: #d1d5db;
    border-color: #f1f1f1;
}
/* Set border color for the entire table and its cells */
/* Search bar styling */
.search-bar {
    margin-bottom: 1.5rem;
    /* Removed float: right; as Bootstrap's col-md-4 offset-md-8 handles alignment */
}

/* Custom CSS for action links (Edit, Delete buttons) */
.action-link {
    background: none;
    border: none;
    padding: 0;
    cursor: pointer;
    text-decoration: none; /* Remove default underline */
    color: #000; /* Black color */
    font-size: inherit;
    font-family: inherit;
    font-weight: bold; /* Make text bold */
}

.action-link:hover {
    text-decoration: underline; /* Add underline on hover */
    color: #000; /* Keep black on hover */
}

.action-link:first-child {
    margin-left: 0;
}
</style>