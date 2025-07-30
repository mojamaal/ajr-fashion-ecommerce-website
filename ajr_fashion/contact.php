<?php require_once 'includes/db_connect.php'; ?>
<?php require_once 'includes/header.php'; ?>

<main class="container mx-auto py-12">
    <h2 class="text-3xl font-bold text-center mb-8">Contact Us</h2>
    <form action="#" method="post" class="checkout max-w-lg mx-auto">
        <div class="mb-4">
            <label for="name" class="block mb-2">Name</label>
            <input type="text" id="name" name="name" required class="w-full p-2 border rounded">
        </div>
        <div class="mb-4">
            <label for="email" class="block mb-2">Email</label>
            <input type="email" id="email" name="email" required class="w-full p-2 border rounded">
        </div>
        <div class="mb-4">
            <label for="message" class="block mb-2">Message</label>
            <textarea id="message" name="message" required class="w-full p-2 border rounded"></textarea>
        </div>
        <button type="submit" class="btn bg-pink-600 text-white px-6 py-3 rounded">Send Message</button>
    </form>
</main>

<?php require_once 'includes/footer.php'; ?>