import { test, expect } from "@playwright/test";

test("user", async ({ page }) => {
  await page.goto("http://localhost/");
  await page.getByRole("button", { name: "Foto de perfil" }).click();
  await page.getByRole("link", { name: "Iniciar sesión" }).click();
  await page.getByRole("textbox", { name: "Correo electrónico" }).click();
  await page
    .getByRole("textbox", { name: "Correo electrónico" })
    .fill("admin@admin.es");
  await page.getByRole("textbox", { name: "Contraseña" }).click();
  await page.getByRole("textbox", { name: "Contraseña" }).fill("alejandria25+");
  await page.getByRole("button", { name: "Iniciar sesión" }).click();
  await page.getByRole("button", { name: "Foto de perfil" }).click();
  await page.getByRole("link", { name: "Panel de administración" }).click();
  await page
    .getByRole("row", { name: "2 mariana.rios89@example.com" })
    .getByRole("button")
    .first()
    .click();
  await page.getByLabel("Selecciona el rol").selectOption("1");
  await page.getByRole("button", { name: "Actualizar" }).click();
  await page
    .locator("div")
    .filter({ hasText: "¡Usuario actualizado" })
    .nth(2)
    .click();
});

test("genres", async ({ page }) => {
  await page.goto("http://localhost/");
  await page.getByRole("button", { name: "Foto de perfil" }).click();
  await page.getByRole("link", { name: "Iniciar sesión" }).click();

  await page
    .getByRole("textbox", { name: "Correo electrónico" })
    .fill("admin@admin.es");
  await page.getByRole("textbox", { name: "Contraseña" }).fill("alejandria25+");
  await page.getByRole("button", { name: "Iniciar sesión" }).click();

  await page.getByRole("button", { name: "Foto de perfil" }).click();
  await page.getByRole("link", { name: "Panel de administración" }).click();
  await page.getByRole("link", { name: "Géneros" }).click();

  // Crear género
  await page.getByRole("button", { name: "Crear" }).click();
  await page.getByRole("textbox", { name: "Nombre" }).fill("PRUEBA");
  await page.click("#action");

  await page.waitForSelector("#toastNotification");
  await page.click("#toastNotification button");

  // Editar género
  await page.getByRole("searchbox", { name: "Buscar:" }).fill("PRUE");
  await page.getByRole("button", { name: "Editar", exact: true }).click();
  await page.getByRole("textbox", { name: "Nombre" }).fill("PRUEBA-A");
  await page.click("#action");

  await page.waitForSelector("#toastNotification");
  await page.click("#toastNotification button");

  // Eliminar género
  page.once("dialog", async (dialog) => {
    if (dialog.type() === "confirm") {
      await dialog.accept(); // Simula hacer click en "Aceptar"
    } else {
      await dialog.dismiss(); // Para otros diálogos, lo descarta
    }
  });

  // Al hacer click en el botón que dispara el confirm
  await page.getByRole("button", { name: "Eliminar", exact: true }).click();

  await page.waitForSelector("#toastNotification");
  await page.click("#toastNotification button");
});

test("books", async ({ page }) => {
  await page.goto("http://localhost/user/login");
  await page.getByRole("textbox", { name: "Correo electrónico" })
    .fill("admin@admin.es");
  await page.getByRole("textbox", { name: "Contraseña" }).fill("alejandria25+");
  await page.getByRole("button", { name: "Iniciar sesión" }).click();
  await page.goto("http://localhost/admin/books");

  await page.getByRole('button', { name: 'Crear' }).click();
  await page.getByRole('textbox', { name: 'Título' }).click();
  await page.getByRole('textbox', { name: 'Título' }).press('CapsLock');
  await page.getByRole('textbox', { name: 'Título' }).fill('libro-test');
  await page.getByRole('textbox', { name: 'Sinopsis Autores: Genres:' }).click();
  await page.getByRole('textbox', { name: 'Sinopsis Autores: Genres:' }).fill('libro-test');
  await page.getByRole('textbox', { name: 'Sinopsis Autores: Genres:' }).press('Tab');
  await page.getByRole('textbox', { name: 'Autores:', exact: true }).press('CapsLock');
  await page.getByRole('textbox', { name: 'Autores:', exact: true }).fill('Anónimo');
  await page.getByRole('textbox', { name: 'Genres:', exact: true }).click();
  await page.getByRole('textbox', { name: 'Genres:', exact: true }).fill('Fantasía');
  await page.getByText('Fantasía', { exact: true }).click();
  await page.click("#action");

  await page.waitForSelector("#toastNotification");
  await page.click("#toastNotification button");

  //Editar libro
  await page.getByRole("searchbox", { name: "Buscar:" }).fill("libro-test");
  await page.getByRole("button", { name: "Editar", exact: true }).click();
  await page.getByRole('textbox', { name: 'Título' }).click();
  await page.getByRole('textbox', { name: 'Título' }).fill('libro-test editar');
  await page.getByRole('textbox', { name: 'Sinopsis Autores: Anónimo' }).click();
  await page.getByRole('textbox', { name: 'Sinopsis Autores: Anónimo' }).fill('PRUEBA editar');
  await page.getByRole('textbox', { name: 'Autores:', exact: true }).click();
  await page.getByRole('textbox', { name: 'Autores:', exact: true }).fill('Anónimo, Jorge Luis Borges');
  await page.getByRole('textbox', { name: 'Genres:', exact: true }).click();
  await page.getByRole('textbox', { name: 'Genres:', exact: true }).fill('Fantasía, Romance');
  await page.getByRole('textbox', { name: 'Genres:', exact: true }).press('ControlOrMeta+-');
  await page.getByRole('textbox', { name: 'Genres:', exact: true }).press('ControlOrMeta+-');
  await page.click("#action");
  await page.waitForSelector("#toastNotification");
  await page.click("#toastNotification button");

  //Eliminar libro
  page.once("dialog", async (dialog) => {
    if (dialog.type() === "confirm") {
      await dialog.accept(); // Simula hacer click en "Aceptar"
    } else {
      await dialog.dismiss(); // Para otros diálogos, lo descarta
    }
  });

  await page.getByRole("button", { name: "Eliminar", exact: true }).click();
  await page.waitForSelector("#toastNotification");
  await page.click("#toastNotification button");

});