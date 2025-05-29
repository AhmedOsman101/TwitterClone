import { type ClassValue, clsx } from "clsx";
import { twMerge } from "tailwind-merge";

export function cn(...inputs: ClassValue[]) {
  return twMerge(clsx(inputs));
}

/**
 * The function `isEqualObjects` compares two objects recursively to determine if they are equal in
 * terms of keys and values.
 * @param firstObject - `firstObject` is the first object that you want to compare for equality with `secondObject`.
 * @param secondObject - `secondObject` is the object that you want to compare with `firstObject`.
 * @returns Returns `true` if the two input objects are equal in terms
 * of their keys and values, and `false` otherwise.
 */
export function isEqualObjects(
  firstObject: unknown,
  secondObject: unknown
): boolean {
  // If both are strictly equal, return true
  if (firstObject === secondObject) return true;

  // If either is not an object or is null, return false
  if (
    typeof firstObject !== "object" ||
    firstObject === null ||
    typeof secondObject !== "object" ||
    secondObject === null
  ) {
    return false;
  }

  // Get keys of both objects
  const keys1 = Object.keys(firstObject);

  // Check if all keys and their values are equal
  return keys1.every(key => {
    // If the key does not exist in secondObject, return false
    if (!Object.hasOwn(secondObject, key)) return false;

    const val1 = (firstObject as Record<PropertyKey, unknown>)[key];
    const val2 = (secondObject as Record<PropertyKey, unknown>)[key];

    // Check if both values are objects and recursively compare
    const areBothObjects =
      typeof val1 === "object" &&
      val1 !== null &&
      typeof val2 === "object" &&
      val2 !== null;

    return areBothObjects ? isEqualObjects(val1, val2) : val1 === val2;
  });
}

/**
 * The `formatNumber` function converts a large number into a more readable
 * format with abbreviations like K for thousand, M for million, and B for billion.
 * @param num - The `num` parameter is the number that you want to format.
 * The `formatNumber` function takes a number as input and formats it based on its magnitude.
 * @returns Returns a formatted string representing the number in a
 * shortened format with a suffix indicating the magnitude.
 */
export function formatNumber(num: number): string {
  if (num >= 1_000_000_000) {
    return `${(num / 1_000_000_000).toFixed(num % 1_000_000_000 === 0 ? 0 : 1)}B`;
  }
  if (num >= 1000000) {
    return `${(num / 1_000_000).toFixed(num % 1_000_000 === 0 ? 0 : 1)}M`;
  }
  if (num >= 1000) {
    return `${(num / 1000).toFixed(num % 1000 === 0 ? 0 : 1)}K`;
  }

  return num.toString();
}

/**
 * The function `getComponent` extracts the last part of a component path from a
 * given page object.
 * @param page - The `page` object contains information the current
 * page, such as its name and path. The function extracts the component name
 * from the `page` object and returns it.
 * @returns The last part of the `component` string after splitting it
 * by "/".
 */
export function getComponent(page: { component: string }): string {
  const component = page.component;

  const splitted = component.split("/");

  return splitted[splitted.length - 1];
}

/**
 * Truncates a string to a specified limit and appends "..." if the string exceeds the limit.
 * @param str - The input string that you want to limit in terms of length.
 * @param limit - The maximum length that the input `string` should be truncated to. If the length of the input `string` exceeds this `limit`, it will be truncated and "..." will be appended to indicate that it has been shortened.
 * @returns The truncated string or the original string if length is below limit.
 */
export function StringLimit(str: string, limit: number): string {
  if (str.length > limit) {
    return `${str.substring(0, limit - 3)}...`;
  }

  return str;
}

/**
 * Checks if an array is empty without using the length property.
 *
 * @param array - The array to check for emptiness.
 * @returns Returns true if the array is empty, false otherwise.
 */
export function isEmptyArray(array: unknown[]): boolean {
  // If we enter this loop, the array has at least one element
  for (const _ in array) return false;
  // If the loop never executed, the array is empty
  return true;
}
