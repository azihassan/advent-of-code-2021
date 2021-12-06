import std;

void main()
{
    int[] state = readln().strip().splitter(",").map!(to!int).array;
    foreach(day; 0 .. 80)
    {
        state.next();
        writeln(day);
    }
    state.length.writeln();
}

void next(ref int[] state)
{
    int newFishCounter = 0;
    int[] nextState = [];
    foreach(ref fish; state)
    {
        if(--fish == -1)
        {
            fish = 6;
            newFishCounter++;
        }
    }

    state ~= 8.repeat(newFishCounter).array;
}
