import { test, expect } from "@playwright/test";
import { login } from "./utils";

test("addLibraryAndChangeBookStatus", async ({ page }) => {
  await login("correoPrueba@example.com", "12345678+a", page);

  await page.goto("http://localhost//book?bookId=250");
  await page.getByRole("link", { name: "Añadir a la biblioteca" }).click();
  await expect(page.getByRole("combobox")).toHaveValue("want to read");
  await page.getByRole("combobox").selectOption("reading");
  await page.getByRole("button", { name: "Guardar Estado" }).click();
  await page.waitForSelector("#toastNotification");
  await page.click("#toastNotification button");
  await page.click(".btn-delete-style");
  await page.waitForSelector("#toastNotification");
  await page.click("#toastNotification button");
});
