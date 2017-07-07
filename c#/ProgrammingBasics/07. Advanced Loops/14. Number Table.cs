﻿using System;

class Program
{
    public static void Main()
    {
        var n = int.Parse(Console.ReadLine());

        for (int row = 0; row < n; row++)
        {
            for (int col = 0; col < n; col++)
            {
                var num = row + col + 1;
                if (num > n)
                {
                    num = -num + 2 * n;
                }
                Console.Write(num + " ");

            }

            Console.WriteLine();
        }

    }
}