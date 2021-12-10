import std;

void main()
{
    ulong[] scores; //is there a sorted container in D ?
    foreach(string line; stdin.lines())
    {
        string remaining = line.strip().complete();
        if(remaining != "")
        {
            scores ~= remaining.countScore();
        }
    }
    scores.sort();
    scores[$ / 2].writeln();
}

string complete(string line)
{
    char[] stack;
    char[char] pairs = [
        ')': '(',
        ']': '[',
        '}': '{',
        '>': '<'
    ];
    char[char] reversePairs = [
        '(': ')',
        '[': ']',
        '{': '}',
        '<': '>'
    ];
    foreach(c; line)
    {
        if(c in pairs)
        {
            if(stack.back != pairs[c])
            {
                return ""; //corrupted
            }
            stack.popBack();
        }
        else
        {
            stack ~= c;
        }
    }
    return stack.retro().map!(c => reversePairs[cast(char) c]).to!string;
}

unittest
{
    assert("[[<[([]))<([[{}[[()]]]".complete() == "");
    assert("[({(<(())[]>[[{[]{<()<>>".complete() == "}}]])})]");
    assert("[(()[<>])]({[<{<<[]>>(".complete() == ")}>]})");
    assert("(((({<>}<{<{<>}{[]{[]{}".complete() == "}}>}>))))");
    assert("{<[[]]>}<{[{[{[]{()[[[]".complete() == "]]}}]}]}>");
    assert("<{([{{}}[<[[[<>{}]]]>[]]".complete() == "])}>");
}

ulong countScore(string remaining)
{
    ulong score = 0;
    int[char] penalties = [
        ')': 1,
        ']': 2,
        '}': 3,
        '>': 4
    ];

    foreach(r; remaining)
    {
        score *= 5;
        score += penalties[r];
    }
    return score;
}

unittest
{
    assert("])}>".countScore() == 294);
    assert("}}]])})]".countScore() == 288957);
    assert(")}>]})".countScore() == 5566);
    assert("}}>}>))))".countScore() == 1480781);
    assert("]]}}]}]}>".countScore() == 995444);
}
