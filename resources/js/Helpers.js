/**
 * The function `isEqualObjects` compares two objects recursively to determine if they are equal in
 * terms of keys and values.
 * @param {object} firstObject - `firstObject` is the first object that you want to compare for equality with `secondObject`.
 * @param {object} secondObject - `secondObject` is the object that you want to compare with `firstObject`.
 * @returns {boolean} Returns `true` if the two input objects are equal in terms
 * of their keys and values, and `false` otherwise.
 */
export function isEqualObjects(firstObject, secondObject) {
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
}

/**
 * The `formatNumber` function converts a large number into a more readable
 * format with abbreviations like K for thousand, M for million, and B for billion.
 * @param {number} num - The `num` parameter is the number that you want to format.
 * The `formatNumber` function takes a number as input and formats it based on its magnitude.
 * @returns {string} Returns a formatted string representing the number in a
 * shortened format with a suffix indicating the magnitude.
 */
export function formatNumber(num) {
	if (num >= 1000000000) {
		return (num / 1000000000).toFixed(num % 1000000000 === 0 ? 0 : 1) + "B";
	} else if (num >= 1000000) {
		return (num / 1000000).toFixed(num % 1000000 === 0 ? 0 : 1) + "M";
	} else if (num >= 1000) {
		return (num / 1000).toFixed(num % 1000 === 0 ? 0 : 1) + "K";
	} else {
		return num.toString();
	}
}
