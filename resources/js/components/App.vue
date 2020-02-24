<template>
	<div>
		<h1>Hello there</h1>
		<router-view></router-view>
	</div>	
</template>

<script>
	export default {
		name: 'App',
		mounted() {
			console.log('Component mounted.')
		}
	}
</script>
<style scoped"></style>