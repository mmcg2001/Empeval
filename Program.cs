using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace CA
{
    class Program
    {
        static void Main(string[] args)
        {
            bool cont = true;
            do
            {
                 for(int x = 0 ; x < 10; x++)
                 {
                    Console.WriteLine("This is loop number: " + x);
                    if (x == 5)
                    {
                        Console.WriteLine("It's half over");
                    }
                 }
                    Console.WriteLine("Do You Want To Continue, Yes Or No: ");
                 if (Console.ReadLine().ToUpper().Equals("YES"))
                 {
                    cont = true;
                 }
                 else
                 {
                    cont = false;
                    Console.WriteLine("Hit Enter To Exit");
                 }
            }while(cont);

            Console.ReadLine();
        }
    }
}
