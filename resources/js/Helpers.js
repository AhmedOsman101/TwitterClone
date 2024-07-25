/**
 * The function `isEqualObjects` compares two objects recursively to determine if they are equal in
 * terms of keys and values.
 * @param {object} firstObject - `firstObject` is the first object that you want to compare for equality with `secondObject`.
 * @param {object} secondObject - `secondObject` is the object that you want to compare with `firstObject`.
 * @returns {boolean} Returns `true` if the two input objects are equal in terms
 * of their keys and values, and `false` otherwise.
 */
export const isEqualObjects = (firstObject, secondObject) => {
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
	return keys1.every((key) => {
		// If the key does not exist in secondObject, return false
		if (!secondObject.hasOwnProperty(key)) return false;

		const val1 = firstObject[key];
		const val2 = secondObject[key];

		// Check if both values are objects and recursively compare
		const areBothObjects =
			typeof val1 === "object" &&
			val1 !== null &&
			typeof val2 === "object" &&
			val2 !== null;

		return areBothObjects ? isEqualObjects(val1, val2) : val1 === val2;
	});
};

/**
 * The `formatNumber` function converts a large number into a more readable
 * format with abbreviations like K for thousand, M for million, and B for billion.
 * @param {number} num - The `num` parameter is the number that you want to format.
 * The `formatNumber` function takes a number as input and formats it based on its magnitude.
 * @returns {string} Returns a formatted string representing the number in a
 * shortened format with a suffix indicating the magnitude.
 */
export const formatNumber = (num) => {
	if (num >= 1000000000) {
		return (num / 1000000000).toFixed(num % 1000000000 === 0 ? 0 : 1) + "B";
	} else if (num >= 1000000) {
		return (num / 1000000).toFixed(num % 1000000 === 0 ? 0 : 1) + "M";
	} else if (num >= 1000) {
		return (num / 1000).toFixed(num % 1000 === 0 ? 0 : 1) + "K";
	} else {
		return num.toString();
	}
};

/**
 * The function `getComponent` extracts the last part of a component path from a
 * given page object.
 * @param {object} page - The `page` object contains information the current
 * page, such as its name and path. The function extracts the component name
 * from the `page` object and returns it.
 * @returns Returns the last part of the `component` string after splitting it
 * by "/".
 */
export const getComponent = (page) => {
	let component = page.component;
	component = component.split("/");
	const index = component.length - 1;
	component = component[index];
	return component;
};

/**
 * Truncates a string to a specified limit and appends "..." if the string exceeds the limit.
 * @param {string} string - The input string that you want to limit in terms of length.
 * @param {number}  limit - The maximum length that the input `string` should be truncated to. If the length of the input `string` exceeds this `limit`, it will be truncated and "..." will be appended to indicate that it has been shortened.
 * @returns {string} The truncated string or the original string if length is below limit.
 */
export const StringLimit = (string, limit) => {
	if (string.length > limit) {
		return `${string.substring(0, limit - 3)}...`;
	}

	return string;
};
