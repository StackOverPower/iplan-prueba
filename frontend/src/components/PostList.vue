<template>
    <div>
      <h1 class="text-2xl font-bold mb-4">Lista de Publicaciones</h1>
  
      <!-- Filtros -->
      <div class="flex gap-4 mb-4">
        <input v-model="startDate" type="date" class="border p-2 rounded" />
        <input v-model="endDate" type="date" class="border p-2 rounded" />
        <button @click="fetchPosts" class="bg-blue-500 text-white px-4 py-2 rounded">Filtrar</button>
      </div>
  
      <!-- Búsqueda -->
      <input v-model="searchQuery" type="text" placeholder="Buscar..." class="border p-2 mb-4 w-full" />
  
      <!-- Lista de publicaciones -->
      <ul>
        <li v-for="post in filteredPosts" :key="post.id" class="border p-4 rounded mb-4">
          <h2 class="text-xl font-semibold">{{ post.title }}</h2>
          <p class="text-gray-700">{{ post.content.substring(0, 100) }}...</p>
          <p class="text-sm text-gray-500">
            Por <strong>{{ post.user.name }}</strong> - {{ formattedDate(post.created_at) }}
          </p>
        </li>
      </ul>
  
      <!-- Aquí está la poginación -->
      <div class="flex gap-2 mt-4">
        <button @click="changePage(currentPage - 1)" :disabled="currentPage === 1" class="px-3 py-1 bg-gray-300 rounded">Anterior</button>
        <span>Página {{ currentPage }} de {{ totalPages }}</span>
        <button @click="changePage(currentPage + 1)" :disabled="currentPage === totalPages" class="px-3 py-1 bg-gray-300 rounded">Siguiente</button>
      </div>
    </div>
  </template>
  
  <style scoped>
  </style>
<script setup>
import { ref, computed, onMounted } from "vue";
import apiClient from "../api";
import moment from "moment";

const posts = ref([]);
const currentPage = ref(1);
const totalPages = ref(1);
const startDate = ref("");
const endDate = ref("");
const searchQuery = ref("");

// Función para obtener los posts desde la API
const fetchPosts = async () => {
  try {
    const response = await apiClient.get("/posts", {
      params: {
        page: currentPage.value,
        start_date: startDate.value || undefined,
        end_date: endDate.value || undefined,
      },
    });
    
    posts.value = response.data.data;
    totalPages.value = response.data.last_page;
  } catch (error) {
    console.error("Error al obtener publicaciones:", error);
  }
};

// Filtrar publicaciones por título o contenido usando propiedades computadas
const filteredPosts = computed(() => {
  return posts.value.filter((post) => 
    post.title.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
    post.content.toLowerCase().includes(searchQuery.value.toLowerCase())
  );
});

// Función para formatear la fecha de creación
const formattedDate = (date) => {
  return moment(date).fromNow();
};

// Cargar posts al montar el componente
onMounted(fetchPosts);

// Función para cambiar de página
const changePage = (newPage) => {
  currentPage.value = newPage;
  fetchPosts();
};
</script>

